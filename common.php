<?php
require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(!defined('ROOT')){
	define('ROOT', dirname( __FILE__ ) . '/');
}
if(!defined('WEB_ROOT')){
	define('WEB_ROOT', './');
}


// Check if settings file exists
if(file_exists(ROOT.'settings.config')){
	// It Does!
	require ROOT.'settings.config';
}
else {
	// No Settings file. Redirect to an error page
	header('Location: '.WEB_ROOT.'init/error.php?e=settings.cfg');
	die();
}


date_default_timezone_set('America/Chicago');

$numberTypes = Array("arabic", "roman", "japanese", "arabic", "roman");

$db = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
function db($query = NULL){
	static $db;

	// Only connect to the database once.
	if(!isset($db)){
		$db = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
		if($db->connect_errno){return ['db_error'=>$db->connect_errno];}
	}

	// Execute a query if provided
	if(!empty($query)){
		$result = $db->query($query);
		// Stop if the DB errors
		if(!$result){
			return FALSE;
			// return $result->error;
		}
		// Format returned rows into an array
		elseif(stripos($query, 'SELECT ') !== FALSE) {
			$return = Array();
			while($row = $result->fetch_assoc()){
				$return[] = $row;
			}
			return (sizeof($return)) ? $return : FALSE;
		}
		else {
			return $result;
		}
	}
	// If all else fails, return the database resource
	return $db;
}

function db_esc($text){
  return db()->real_escape_string($text);
}

// Check if DB successfully connects
if($db->connect_errno){
	header('Location: '.WEB_ROOT.'init/error.php?e=mysql-'.$db->connect_errno);
	die();
}


// Includes a file from the template directory
function template($part){
	require_once(ROOT.'template/'.$part.'.php');
}


/**
* Returns multidimensional array of all information in week table
* @param optional string $direction to indicate which way to sort, default ascending
* @return array of events
*/
function getListOfEvents($direction = "ASC"){
	$sql = "SELECT * FROM `week` ORDER BY `date` $direction, `id` DESC";
	$data = db($sql);

	return $data;
}

function getListOfViewers($sortBy = 'id', $direction = "DESC"){
	$sql = "SELECT * FROM `viewers` ORDER BY `$sortBy` $direction";
	$data = db($sql);

	return $data;
}

function getMoviegoerById($id){
	$sql = "SELECT `name` FROM `viewers` WHERE `id` = $id";
	$data = db($sql)[0]['name'];

	return $data;
}

function getMovieById($id){
	$sql = "SELECT `name` FROM `films` WHERE `id` = $id";
	$data = db($sql)[0]['name'];

	return $data;
}

function getMovieByName($name){
	$sql = "SELECT * FROM `films` WHERE `name` = '$name'";
	$data = db($sql)[0];

	return $data;
}

function getMoviegoerColorById($id){
	$sql = "SELECT `color` FROM `viewers` WHERE `id` = $id";
	$data = db($sql)[0]['color'];

	return $data;
}

function getMoviegoerColorByName($name){
	$sql = "SELECT `color` FROM `viewers` WHERE `name` = '$name'";
	$data = db($sql)[0]['color'];

	return $data;
}

function getWinningMoviegoer($id){
	$sql = "SELECT `` FROM `viewers` WHERE `id` = $id";
	$data = db($sql)[0]['color'];

	return $data;
}

function getViewerName($id){
	return getMoviegoerById($id);
}

function setMovieRuntime($id, $runtime){
	$sql = "UPDATE `films` SET `runtime` = $runtime WHERE `id` = $id";
	$data = db($sql);

	return;

}

function countSpins(){
	$sql = "SELECT COUNT(*) AS `total` FROM `week`";
	$data = db($sql)[0]['total'];
	return $data;
}

function countErrorSpins(){
	$sql = "SELECT `error_spin` from `week` WHERE `error_spin` != ''";
	$data = db($sql);

	$error_spins = 0;

	foreach($data as $errors){
		$error_spins += count(explode(",", $errors['error_spin']));
	}

	return($error_spins);
}

function getErrorSpins(){
	$sql = "SELECT `error_spin` from `week` WHERE `error_spin` != ''";
	$data = db($sql);

	$error_spins = Array();

	foreach($data as $errors){
		$list = explode(",", $errors['error_spin']);

		if(count($list) > 1){
			foreach($list as $item){
				$error_spins[] = str_replace(" ","",$item);
			}
		} else {
			$error_spins[] = str_replace(" ","",$list[0]);
		}
	}

	$histogram = Array();

	for($i = 1; $i <= 12; $i++){
		$histogram[$i] = 0;
	}

	foreach($error_spins as $value){
		$histogram[$value]++;
	}

	return $histogram;
}

function countWeeks(){
	$sql = "SELECT COUNT(*) AS `total` FROM `week`";
	$data = db($sql)[0]['total'];
	return $data;
}

function countWinsForNumber($number){
	$sql = "SELECT COUNT(*) AS `total` FROM `week` WHERE `winning_wedge` = $number";
	$data = db($sql)[0]['total'];
	return $data;
}

function getSelectionTypes(){
	$sql = "SELECT `name` FROM `spinners` WHERE `uses` > 0";
	$data = db($sql);
	$tools = Array();
	foreach($data as $method){
		$tools[] = $method['name'];
	}
	//asort($tools);
	return $tools;
}

function getNumbersFromTool($tool){
	$sql = "SELECT `winning_wedge` FROM `week` WHERE `selection_method` = '$tool'";
	$data = db($sql);
	$count = count($data);

	$histogram = makeHistogram($data);

	return $histogram;
}


function makeHistogram($data){

	$histogram = Array();

	for($i = 1; $i <= 12; $i++){
		$histogram[$i] = 0;
	}

	foreach($data as $aWedge){
		$histogram[$aWedge['winning_wedge']]++;
	}

	return $histogram;
}


function HTMLToRGB($htmlCode)
  {
    if($htmlCode[0] == '#')
      $htmlCode = substr($htmlCode, 1);

    if (strlen($htmlCode) == 3)
    {
      $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
    }

    $r = hexdec($htmlCode[0] . $htmlCode[1]);
    $g = hexdec($htmlCode[2] . $htmlCode[3]);
    $b = hexdec($htmlCode[4] . $htmlCode[5]);

  return "rgba($r, $g, $b, .1)";
}

function getMovieList(){
	$sql = "SELECT * FROM `films` WHERE `id` != 0 ORDER BY `name` ASC";
	$data = db($sql);

	return $data;
}

function countMovieList(){
	$sql = "SELECT count(*) AS 'count' FROM `films` WHERE `id` != 0 ORDER BY `name` ASC";
	$data = db($sql)[0];

	return $data['count'];
}

function countWonMovies(){
	$sql = "SELECT count(*) AS 'count' FROM `week`";
	$data = db($sql)[0];

	return $data['count'];
}

function countWatchedMovies(){
	$sql = "SELECT `winning_film` FROM `week`";
	$data = db($sql);
	$list = array_column($data, "winning_film");

	return count(array_unique($list));
}


function listWatchedMovies(){
	$sql = "SELECT `winning_film` FROM `week`";
	$data = db($sql);
	$list = array_column($data, "winning_film");

	return array_unique($list);
}

function listAllWatchedMovies(){
	$sql = "SELECT `winning_film` FROM `week`";
	$data = db($sql);
	$list = array_column($data, "winning_film");

	return $list;
}

function calculateTotalWatchtime(){
	$sql = "SELECT SUM(runtime) AS runtime FROM `week`";
	$totalMinutes = db($sql)[0]['runtime'];

	return $totalMinutes;
}

function calculateYearlyWatchtime($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT SUM(runtime) AS runtime FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$totalMinutes = db($sql)[0]['runtime'];
	return $totalMinutes;
}

function calculate_attendance($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT `attendees` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$total_attending = db($sql);
	//print_r($total_attending);

	$total = 0;
	foreach($total_attending as $value){
	$total += count(explode(',',$value['attendees']));
	}

	return $total;
}

function getMovieRuntime($id){
	$sql = "SELECT `runtime` FROM `films` WHERE `id` = $id";
	$data = db($sql)[0]['runtime'];

	return $data;
}

function countTotalFilmApperances($filmID){

	$counter = 0;

	for($i = 1; $i <= 12; $i++){
		$sql = "SELECT COUNT(*) AS `count` FROM `week` WHERE `wheel_$i` = $filmID";
		$data = db($sql)[0]['count'];

		$counter = $counter + $data;
	}

	return $counter;
}

function get_last_winner(){
	$sql = "SELECT `winning_moviegoer` FROM `week` ORDER BY `date` DESC LIMIT 1";
	$data = db($sql)[0]['winning_moviegoer'];

	return $data;
}

function winners_by_year($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT `winning_moviegoer`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `winning_moviegoer`";
	$winners = db($sql);
	$win = Array();
	foreach($winners as $a_winner){
		$win[$a_winner['winning_moviegoer']] = $a_winner['COUNT(*)'];
	}
	return $win;
}

function biggest_winner($year){
	$winners = winners_by_year($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top_winners' => $top_winners, 'count' => $max);
}

function spins_by_year($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT `spinner`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `spinner`";
	$winners = db($sql);
	$win = Array();
	foreach($winners as $a_winner){
		$win[$a_winner['spinner']] = $a_winner['COUNT(*)'];
	}
	return $win;
}

function biggest_spinner($year){
	$winners = spins_by_year($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top_spinner' => $top_winners, 'count' => $max);
}


function blank_by_year($year, $blank, $ignore_viewer_choice = FALSE){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	if($ignore_viewer_choice == TRUE){
		$sql = "SELECT `$blank`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `$blank`";
	} else {
		$sql = "SELECT `$blank`, COUNT(*) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `$blank`";
	}

	$winners = db($sql);

	$win = Array();
	foreach($winners as $a_winner){
		$win[$a_winner[$blank]] = $a_winner['COUNT(*)'];
	}

	return $win;
}

function biggest_blank($year, $blank, $ignore_viewer_choice = FALSE){
	$winners = blank_by_year($year, $blank, $ignore_viewer_choice);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top' => $top_winners, 'count' => $max);
}


function count_minutes_per_service($year = null){
	if($year == null){
		$sql = "SELECT `format`, SUM(`runtime`) FROM `week` GROUP BY `format` ORDER BY SUM(`runtime`) DESC";
	} else {
		$time1 = $year."-01-01";
		$time2 = $year."-12-31";
		$sql = "SELECT `format`, SUM(`runtime`) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `format` ORDER BY SUM(`runtime`) DESC";
	}
	$result = db($sql);

	return $result;
}

function yearly_viewer_attendance($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT `attendees` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$array = db($sql);
	//print_r($array);
	$full_list = Array();
	foreach($array as $value){
		//print_r($value);
		$new = explode(',',$value['attendees']);
		foreach($new as $v2){
			if(isset($full_list[trim($v2)])){
				$full_list[trim($v2)]++;
			} else {
				$full_list[trim($v2)] = 1;
			}
		}
	}

	arsort($full_list);
	return $full_list;

}

function highest_attendance($year){
	$winners = yearly_viewer_attendance($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top' => $top_winners, 'count' => $max);
}

function most_requested_film($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT `wheel_1`,`wheel_2`,`wheel_3`,`wheel_4`,`wheel_5`,`wheel_6`,`wheel_7`,`wheel_8`,`wheel_9`,`wheel_10`,`wheel_11`,`wheel_12` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$array = db($sql);
	$movieList = Array();
	foreach($array as $list){
		foreach($list as $movie){
			if(isset($movieList[$movie])){
				$movieList[$movie]++;
			} else {
				$movieList[$movie] = 1;
			}
			
		}
	}
	unset($movieList[0]);
	$max = max($movieList);
	$top_winners = array_keys($movieList, $max);
	return Array('top' => $top_winners, 'count' => $max);
}

function getFirstOrLastDate($filmID, $type = "First"){
	switch ($type) {
		case 'First':
		$query_first = "SELECT `date` FROM `week` WHERE `wheel_1` = {$filmID} OR `wheel_2` = {$filmID} OR `wheel_3` = {$filmID} OR `wheel_4` = {$filmID} OR `wheel_5` = {$filmID} OR `wheel_6` = {$filmID} OR `wheel_7` = {$filmID} OR `wheel_8` = {$filmID} OR `wheel_9` = {$filmID} OR `wheel_10` = {$filmID} OR `wheel_11` = {$filmID} OR `wheel_12` = {$filmID} ORDER BY `date` ASC LIMIT 0,1";
			break;
		case 'Last':
		$query_first = "SELECT `date` FROM `week` WHERE `wheel_1` = {$filmID} OR `wheel_2` = {$filmID} OR `wheel_3` = {$filmID} OR `wheel_4` = {$filmID} OR `wheel_5` = {$filmID} OR `wheel_6` = {$filmID} OR `wheel_7` = {$filmID} OR `wheel_8` = {$filmID} OR `wheel_9` = {$filmID} OR `wheel_10` = {$filmID} OR `wheel_11` = {$filmID} OR `wheel_12` = {$filmID} ORDER BY `date` DESC LIMIT 0,1";
			break;
	}

	$data = db($query_first)[0];

	return $data['date'];

}

function convert_Frist_and_Last_to_Column(){
	$movies = getMovieList();

	foreach($movies as $movie){
		$id = $movie['id'];
		$first_date = getFirstOrLastDate($movie['id'], "First");
		$last_date = getFirstOrLastDate($movie['id'], "Last");

		$sql = "UPDATE `films` SET `first_instance` = '$first_date', `last_instance` = '$last_date' WHERE `id` = $id";
		print_r($sql);
		db($sql);

	}
}

function countWeeksOnWheel($filmID){
	$query_first = "SELECT COUNT(*) AS `count` FROM `week` WHERE `wheel_1` = {$filmID} OR `wheel_2` = {$filmID} OR `wheel_3` = {$filmID} OR `wheel_4` = {$filmID} OR `wheel_5` = {$filmID} OR `wheel_6` = {$filmID} OR `wheel_7` = {$filmID} OR `wheel_8` = {$filmID} OR `wheel_9` = {$filmID} OR `wheel_10` = {$filmID} OR `wheel_11` = {$filmID} OR `wheel_12` = {$filmID}";

	$data = db($query_first)[0];

	return $data['count'];
}

function didIWin($filmID){
	$sql = "SELECT `date` FROM `week` WHERE `winning_film` = $filmID ORDER BY `date` ASC";

	$data = db($sql);

	if($data){
		$count = count($data);
		$return_this = $data[0]['date'];
	} else {
		$count = "";
		$return_this = NULL;
	}

	return Array("count" => $count, "first_win"=> $return_this);

}

/**
* Returns array of viewers who put a given film on the wheel.
* @param int $filmID id value for a given film
* @return array( "User ID" => "Number of times they picked a given film")
*/
function getPickers_v3($filmID){
	$movie_pickers = [];

	$sql = "SELECT * FROM `week` WHERE `wheel_1` = $filmID OR `wheel_2` = $filmID OR `wheel_3` = $filmID OR `wheel_4` = $filmID OR `wheel_5` = $filmID OR `wheel_6` = $filmID OR `wheel_7` = $filmID OR `wheel_8` = $filmID OR `wheel_9` = $filmID OR `wheel_10` = $filmID OR `wheel_11` = $filmID OR `wheel_12` = $filmID ";

	$data_pickers = db($sql);

	foreach($data_pickers as $week){
		for($i = 1; $i <= 12; $i++){
			if($week["wheel_$i"] == $filmID){
				if(isset($movie_pickers[$week["moviegoer_$i"]])){
					$movie_pickers[$week["moviegoer_$i"]]++;
				} else {
					$movie_pickers[$week["moviegoer_$i"]] = 1;
				}
			}
		}
	}
	return $movie_pickers;
}


function getPickers($filmID){
	$movie_pickers = [];
	for($i = 1; $i <= 12; $i++){
		$query_pickers = "SELECT `moviegoer_$i` AS `moviegoer` FROM `week` WHERE `wheel_$i` = $filmID";
		$data_pickers = db($query_pickers);

		if($data_pickers){
			foreach($data_pickers as $movie_picker){
				if(empty($movie_pickers[$movie_picker['moviegoer']])){
					$movie_pickers[$movie_picker['moviegoer']] = 1;
				}
				else {
					$movie_pickers[$movie_picker['moviegoer']]++;
				}
			}

		}
	}
	return $movie_pickers;
}

function countAttendance($id){
	$sql = "SELECT count(*) AS `attendance` FROM `week`  WHERE `attendees` LIKE '%{$id}%' ORDER BY `date` ASC";
	$data = db($sql);
	return $data[0]['attendance'];
}

function countAttendanceReal($id){
	$sql = "SELECT `attendees` FROM `week` WHERE `attendees` LIKE '%{$id}%' ORDER BY `date` ASC";
	$data = db($sql);

	$allAttendence = Array();

	foreach($data as $aWeek){
		$aWeek2 = explode(", ", $aWeek['attendees']);
		foreach($aWeek2 as $aPerson){
			$allAttendence[] = $aPerson;
		}
	}

	$values = array_count_values($allAttendence);
	return $values[$id];

}

function countScribe($id){
	$sql = "SELECT count(*) AS `scribe` FROM `week`  WHERE `scribe` LIKE '%{$id}%' ORDER BY `date` ASC";
	$data = db($sql);
	return $data[0]['scribe'];
}

function listMyTotalPicksReal($id){
	$weeks = getListOfEvents();
	$allMyPicks = Array();
	foreach($weeks as $aWeek){
			$allMyPicks = array_merge($allMyPicks, myMoviePicksForWeekID($aWeek['id'], $id));
	}
	//print_r($allMyPicks);
	return $allMyPicks;
}

function myMoviePicksForWeekID($id, $viewerID){
	$sql = "SELECT * FROM `week` WHERE `id` = '{$id}' ORDER BY `date` ASC";
	$data = db($sql)[0];
	//print_r($data);
	$returnMe = Array();
	for($i = 1; $i < 13; $i++){
		$movieID = $data["wheel_$i"];
		$pickerID = $data["moviegoer_$i"];
		if($pickerID == $viewerID){
					$returnMe[] = Array("filmID" => $movieID, "moviegoerID" => $pickerID);
		}
	}
	return $returnMe;
}

function countMyTotalPics($id){
	$myList = listMyTotalPicksReal($id);

	return count($myList);
}


function calculateMyUniquePicks($id){
	$myList = listMyTotalPicksReal($id);
	$myUnique = array_column($myList, 'filmID');
	return count(array_unique($myUnique));
}


function getMyMovieYears($id){
	$myList = listMyTotalPicksReal($id);
	$myUnique = array_column($myList, 'filmID');

	$yearList = Array();

	foreach($myUnique as $aFilmID){

		$sql = "SELECT `year` FROM `films` WHERE `id` = '$aFilmID'";
		$result = db($sql);

		//print_r($result);

		$yearList[] = $result[0]['year'];
	}

	$yearList = array_filter(array_unique($yearList));



	return round(array_sum($yearList)/count($yearList));
	//return $yearList;
}


function winningWedgesFromSpecificSpinner($id, $includeBadSpins = FALSE){
	$sql = "SELECT `winning_wedge` FROM `week` WHERE `spinner` = $id";
	$data = db($sql);
	$returnMe = Array();

	if($data != null){
		foreach($data as $item){
			$returnMe[] = $item['winning_wedge'];
		}

		if($includeBadSpins == TRUE){

			$sql = "SELECT `error_spin` FROM `week` WHERE `spinner` = $id";
			$data = db($sql);

			foreach($data as $error){

				$allErrors = explode(",", $error['error_spin']);

				foreach($allErrors as $wedge){
					if($wedge !=''){
						//echo $wedge . "\n";
						$returnMe[] = $wedge . "*";
					}
				}
		}
		}
	}
	return $returnMe;
}

function winningPickStats($user_id){
	$wedge_query = 'SELECT `id`,`winning_wedge` FROM `week`';
	$winning_wedges = db($wedge_query);

	$wins = 0;

	if($winning_wedges != null){
		foreach($winning_wedges as $wedge){
			$win_query = sprintf("SELECT * FROM `week` WHERE `id`='%d' AND `moviegoer_%d`='%d'", $wedge['id'], $wedge['winning_wedge'], $user_id);
			$win_data = db($win_query) ?: [];

			$wins += count($win_data);
		}
	}

	return $wins;
}

function countMySpins($id){
	$sql = "SELECT count(*) AS `count` FROM `week` WHERE `spinner` = '$id'";
	$good = db($sql)[0]['count'];

	$sql = "SELECT `error_spin` FROM `week` WHERE `spinner` = '$id' AND `error_spin` != ''";
	$data = db($sql);

	$error_spins = Array();
	if($data){
		foreach($data as $errors){
			$list = explode(",", $errors['error_spin']);

			if(count($list) > 1){
				foreach($list as $item){
					$error_spins[] = str_replace(" ","",$item);
				}
			} else {
				$error_spins[] = str_replace(" ","",$list[0]);
			}
		}
	}

	$bad = count($error_spins);

	$total = $good+$bad;

	return Array('good' => $good, 'bad' => $bad, 'total' => $total);
}

function countMySpins_noChoice($id){
	$sql = "SELECT count(*) AS `count` FROM `week` WHERE `spinner` = '$id' AND `selection_method` != 'viewer choice'";
	$good = db($sql)[0]['count'];

	$sql = "SELECT `error_spin` FROM `week` WHERE `spinner` = '$id' AND `error_spin` != '' AND `selection_method` != 'viewer choice'";
	$data = db($sql);

	$error_spins = Array();
	if($data){
		foreach($data as $errors){
			$list = explode(",", $errors['error_spin']);

			if(count($list) > 1){
				foreach($list as $item){
					$error_spins[] = str_replace(" ","",$item);
				}
			} else {
				$error_spins[] = str_replace(" ","",$list[0]);
			}
		}
	}

	$bad = count($error_spins);

	$total = $good+$bad;

	return Array('good' => $good, 'bad' => $bad, 'total' => $total);
}

function listOfSpunNumbersByViewer($id){
	$sql = "SELECT `winning_wedge`, `error_spin` FROM `week` WHERE `spinner` = $id";
	$data = db($sql);

	$list = Array();

	foreach($data as $spin){
		$list[] = $spin['winning_wedge'];
		if($spin['error_spin'] != ""){
			$espin = explode(",", $spin['error_spin']);
			if(count($espin) > 1){
				foreach($espin as $ii){
					$list[] = str_replace(" ","",$ii)."*";
				}
			} else {
				$list[] = str_replace(" ","",$spin['error_spin'])."*";
			}
		}
	}

	return $list;

}


function listOfSpunNumbersByViewer_noChoice($id){
	$sql = "SELECT `winning_wedge`, `error_spin` FROM `week` WHERE `spinner` = $id AND `selection_method` != 'viewer choice'";
	$data = db($sql);

	$list = Array();
	if($data != NULL){
		foreach($data as $spin){
			$list[] = $spin['winning_wedge'];
			if($spin['error_spin'] != ""){
				$espin = explode(",", $spin['error_spin']);
				if(count($espin) > 1){
					foreach($espin as $ii){
						$list[] = str_replace(" ","",$ii)."*";
					}
				} else {
					$list[] = str_replace(" ","",$spin['error_spin'])."*";
				}
			}
		}
	}
	return $list;
}

function graphSpunNumbersByViewer($id){

	$numbers = listOfSpunNumbersByViewer_noChoice($id);

	$histogram = Array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);

	foreach($numbers as $aNumber){

		$histogram[str_replace("*", "", $aNumber)]++;
	}

	return $histogram;

}

function displayNumbers($number, $type){
	global $numberTypes;
	if($type == "random"){
		$type = $numberTypes[rand(0,4)];
	}

	switch ($type) {
		case 'japanese':
			# code...
			$formattedNumber = \JapaneseNumerals\JapaneseNumerals::fromArabicToJapanese($number);
			break;

		case 'roman':
			# code...
			$formattedNumber = numberToRomanRepresentation($number);
			break;

		case 'arabic':
		default:
			# code...
			$formattedNumber = $number;
			break;
	}

	return $formattedNumber;
}

/**
 * @param int $number
 * @return string
 */
function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function getSpunColors($id){
	$sql = "SELECT * FROM `week` WHERE `spinner` = $id";
	$data = db($sql);

	$list = Array();

	//global $wheel_color;

	$wheel_color = getWheelColors();

	if($data != NULL){
		foreach($data as $item){
			$list[] = $wheel_color[$item['selection_method']][$item['winning_wedge']];
		}
	}


	return $list;
}

function getWheelColors(){
	$sql = "SELECT * FROM `spinners`";
	$data = db($sql);

	//print_r($data);
	$wheel_colors = Array();

	foreach($data as $aWheel){
		$wheel_colors[$aWheel['name']] = Array( 1 => $aWheel['wedge_1'], 2 => $aWheel['wedge_2'], 3 => $aWheel['wedge_3'], 4 => $aWheel['wedge_4'], 5 => $aWheel['wedge_5'], 6 => $aWheel['wedge_6'], 7 => $aWheel['wedge_7'], 8 => $aWheel['wedge_8'], 9 => $aWheel['wedge_9'], 10 => $aWheel['wedge_10'], 11 => $aWheel['wedge_11'], 12 => $aWheel['wedge_12'] );
	}

	return $wheel_colors;
}

function getSpunViewers($id){
	$sql = "SELECT * FROM `week` WHERE `spinner` = $id";
	$data = db($sql);

	$list = Array();

	foreach($data as $item){
		$name = getViewerName($item['moviegoer_'.$item['winning_wedge']]);


		if(array_key_exists($name, $list)){
			$list[$name]++;
		} else {
			$list[$name] = 1;
		}

		//$list[] = getViewerName($item['moviegoer_'.$item['winning_wedge']]);
		//$list[] = $item['selection_method'] [$item['winning_wedge'];
	}

	$plist = Array();
	foreach($list as $key => $value){
		$plist[] = $key . " (". $value .")";
	}

	return $plist;
}

function getSpunViewers_v2($id){
	$sql = "SELECT * FROM `week` WHERE `spinner` = $id AND `selection_method` != 'viewer choice'";
	$data = db($sql);

	$list = Array();

	if($data != NULL){
		foreach($data as $item){
			$name = getViewerName($item['moviegoer_'.$item['winning_wedge']]);
			if(array_key_exists($name, $list)){
				$list[$name]++;
			} else {
				$list[$name] = 1;
			}
			//$list[] = getViewerName($item['moviegoer_'.$item['winning_wedge']]);
			//$list[] = $item['selection_method'] [$item['winning_wedge'];
		}
	}

	return $list;
}

function get_streakers(){
	$sql = "SELECT `winning_wedge`, `id` FROM `week` ORDER BY `date`, `id` ASC";

	$result = db($sql);

	$current_streak = Array('viewer' => 0, 'count' => 0);
	$longest_streak = Array('viewer' => 0, 'count' => 0);

	foreach($result as $event){
		$winner = get_moviegoer_from_wedge($event['winning_wedge'], $event['id']);
		if($winner == $current_streak['viewer']){
			$current_streak['count']++;
			//echo "increase\n";
		} else {
			$current_streak['viewer'] = $winner;
			$current_streak['count'] = 1;
			//echo "reset \n";
		}

		if($longest_streak['count'] < $current_streak['count']){
			$longest_streak['viewer'] = $current_streak['viewer'];
			$longest_streak['count'] = $current_streak['count'];
		}
	}

	return Array("longest" => $longest_streak, "current" => $current_streak);

}


function getMovieRatingReal($id){
	$sql = "SELECT (COALESCE(`tomatometer`,0)+COALESCE(`rt_audience`,0)+COALESCE(`imdb`,0)) / ( COUNT(`tomatometer`) + COUNT(`rt_audience`) + COUNT(`imdb`) ) AS `avg_rating` , `films`.`name` FROM  `films` WHERE  `id` = '$id'";
	$result = db($sql);

	//print_r($sql);
	//print_r($result);

	return round($result[0]['avg_rating'], 1)."%";
}


function getMovieRating($id){

	//SELECT (`tomatometer`+`rt_audience`+`imdb`) / ( COUNT(`tomatometer`) + COUNT(`rt_audience`) + COUNT(`imdb`) ) AS `avg_rating` , `films`.`name` FROM  `films` WHERE  `id` = 40;

	$sql = "SELECT * FROM `films` WHERE `id` = '$id'";

	$result = db($sql)[0];

	$rating_total = 0;
	$rating_divisor = 0;

	$ratings_list = Array('tomatometer', 'rt_audience', 'imdb', 'metacritic', 'meta_userscore');

	foreach($ratings_list as $list){
		if(!is_null($result[$list])){
			$rating_total += $result[$list];
			$rating_divisor += 1;
		}
	}

	if($rating_divisor > 0){
		$value = round(($rating_total/$rating_divisor),0);
		return $value . "%";
	} else {
		//$value = "";
		return FALSE;
	}
}


function get_freshness($array){
	return round((array_sum($array)/(count(array_filter($array))*100))*100, 0);
}


function get_movie_year($filmID){
	$sql = "SELECT `year` FROM `films` WHERE `id` = $filmID";
	$result = db($sql)[0];


	return $result['year'];
}

function get_viewer_years_list($id){
	//SELECT `week`.`id`, `date`, `moviegoer_1`, `moviegoer_2`, `moviegoer_3`, `moviegoer_4`, `moviegoer_5`, `moviegoer_6`, `moviegoer_7`, `moviegoer_8`, `moviegoer_9`, `moviegoer_10`, `moviegoer_11`, `moviegoer_12`, `film_1`.`year` AS `year_1`, `film_2`.`year` AS `year_2`, `film_3`.`year` AS `year_3`, `film_4`.`year` AS `year_4`, `film_5`.`year` AS `year_5`, `film_6`.`year` AS `year_6`, `film_7`.`year` AS `year_7`, `film_8`.`year` AS `year_8`, `film_9`.`year` AS `year_9`, `film_10`.`year` AS `year_10`, `film_11`.`year` AS `year_11`, `film_12`.`year` AS `year_12` FROM `week` LEFT JOIN `films` AS `film_1` ON (`week`.`wheel_1` = `film_1`.`id`) LEFT JOIN `films` AS `film_2` ON (`week`.`wheel_2` = `film_2`.`id`) LEFT JOIN `films` AS `film_3` ON (`week`.`wheel_3` = `film_3`.`id`) LEFT JOIN `films` AS `film_4` ON (`week`.`wheel_4` = `film_4`.`id`) LEFT JOIN `films` AS `film_5` ON (`week`.`wheel_5` = `film_5`.`id`) LEFT JOIN `films` AS `film_6` ON (`week`.`wheel_6` = `film_6`.`id`) LEFT JOIN `films` AS `film_7` ON (`week`.`wheel_7` = `film_7`.`id`) LEFT JOIN `films` AS `film_8` ON (`week`.`wheel_8` = `film_8`.`id`) LEFT JOIN `films` AS `film_9` ON (`week`.`wheel_9` = `film_9`.`id`) LEFT JOIN `films` AS `film_10` ON (`week`.`wheel_10` = `film_10`.`id`) LEFT JOIN `films` AS `film_11` ON (`week`.`wheel_11` = `film_11`.`id`) LEFT JOIN `films` AS `film_12` ON (`week`.`wheel_12` = `film_12`.`id`) WHERE ( `moviegoer_1` = '$id' OR `moviegoer_2` = '$id' OR `moviegoer_3` = '$id' OR `moviegoer_4` = '$id' OR `moviegoer_5` = '$id' OR `moviegoer_6` = '$id' OR `moviegoer_7` = '$id' OR `moviegoer_8` = '$id' OR `moviegoer_9` = '$id' OR `moviegoer_10` = '$id' OR `moviegoer_11` = '$id' OR `moviegoer_12` = '$id' );

	$sql = "SELECT `week`.`id`, `date`, `moviegoer_1`, `moviegoer_2`, `moviegoer_3`, `moviegoer_4`, `moviegoer_5`, `moviegoer_6`, `moviegoer_7`, `moviegoer_8`, `moviegoer_9`, `moviegoer_10`, `moviegoer_11`, `moviegoer_12`, `film_1`.`year` AS `year_1`, `film_2`.`year` AS `year_2`, `film_3`.`year` AS `year_3`, `film_4`.`year` AS `year_4`, `film_5`.`year` AS `year_5`, `film_6`.`year` AS `year_6`, `film_7`.`year` AS `year_7`, `film_8`.`year` AS `year_8`, `film_9`.`year` AS `year_9`, `film_10`.`year` AS `year_10`, `film_11`.`year` AS `year_11`, `film_12`.`year` AS `year_12` FROM `week` LEFT JOIN `films` AS `film_1` ON (`week`.`wheel_1` = `film_1`.`id`) LEFT JOIN `films` AS `film_2` ON (`week`.`wheel_2` = `film_2`.`id`) LEFT JOIN `films` AS `film_3` ON (`week`.`wheel_3` = `film_3`.`id`) LEFT JOIN `films` AS `film_4` ON (`week`.`wheel_4` = `film_4`.`id`) LEFT JOIN `films` AS `film_5` ON (`week`.`wheel_5` = `film_5`.`id`) LEFT JOIN `films` AS `film_6` ON (`week`.`wheel_6` = `film_6`.`id`) LEFT JOIN `films` AS `film_7` ON (`week`.`wheel_7` = `film_7`.`id`) LEFT JOIN `films` AS `film_8` ON (`week`.`wheel_8` = `film_8`.`id`) LEFT JOIN `films` AS `film_9` ON (`week`.`wheel_9` = `film_9`.`id`) LEFT JOIN `films` AS `film_10` ON (`week`.`wheel_10` = `film_10`.`id`) LEFT JOIN `films` AS `film_11` ON (`week`.`wheel_11` = `film_11`.`id`) LEFT JOIN `films` AS `film_12` ON (`week`.`wheel_12` = `film_12`.`id`) WHERE ( `moviegoer_1` = '$id' OR `moviegoer_2` = '$id' OR `moviegoer_3` = '$id' OR `moviegoer_4` = '$id' OR `moviegoer_5` = '$id' OR `moviegoer_6` = '$id' OR `moviegoer_7` = '$id' OR `moviegoer_8` = '$id' OR `moviegoer_9` = '$id' OR `moviegoer_10` = '$id' OR `moviegoer_11` = '$id' OR `moviegoer_12` = '$id' )";

		$result = db($sql);
}

function get_viewer_ratings_real($id){
	$sql = "SELECT `week`.`id`, `date`, `moviegoer_1`, `moviegoer_2`, `moviegoer_3`, `moviegoer_4`, `moviegoer_5`, `moviegoer_6`, `moviegoer_7`, `moviegoer_8`, `moviegoer_9`, `moviegoer_10`, `moviegoer_11`, `moviegoer_12`,
(COALESCE(`film_1`.`tomatometer`,0) + COALESCE(`film_1`.`rt_audience`,0) + COALESCE(`film_1`.`imdb`,0)) / ( COUNT(`film_1`.`tomatometer`) + COUNT(`film_1`.`rt_audience`) + COUNT(`film_1`.`imdb`) ) AS `avg_1`, (COALESCE(`film_2`.`tomatometer`,0) + COALESCE(`film_2`.`rt_audience`,0) + COALESCE(`film_2`.`imdb`,0)) / ( COUNT(`film_2`.`tomatometer`) + COUNT(`film_2`.`rt_audience`) + COUNT(`film_2`.`imdb`) ) AS `avg_2`, (COALESCE(`film_3`.`tomatometer`,0) + COALESCE(`film_3`.`rt_audience`,0) + COALESCE(`film_3`.`imdb`,0)) / ( COUNT(`film_3`.`tomatometer`) + COUNT(`film_3`.`rt_audience`) + COUNT(`film_3`.`imdb`) ) AS `avg_3`, (COALESCE(`film_4`.`tomatometer`,0) + COALESCE(`film_4`.`rt_audience`,0) + COALESCE(`film_4`.`imdb`,0)) / ( COUNT(`film_4`.`tomatometer`) + COUNT(`film_4`.`rt_audience`) + COUNT(`film_4`.`imdb`) ) AS `avg_4`, (COALESCE(`film_5`.`tomatometer`,0) + COALESCE(`film_5`.`rt_audience`,0) + COALESCE(`film_5`.`imdb`,0)) / ( COUNT(`film_5`.`tomatometer`) + COUNT(`film_5`.`rt_audience`) + COUNT(`film_5`.`imdb`) ) AS `avg_5`, (COALESCE(`film_6`.`tomatometer`,0) + COALESCE(`film_6`.`rt_audience`,0) + COALESCE(`film_6`.`imdb`,0)) / ( COUNT(`film_6`.`tomatometer`) + COUNT(`film_6`.`rt_audience`) + COUNT(`film_6`.`imdb`) ) AS `avg_6`, (COALESCE(`film_7`.`tomatometer`,0) + COALESCE(`film_7`.`rt_audience`,0) + COALESCE(`film_7`.`imdb`,0)) / ( COUNT(`film_7`.`tomatometer`) + COUNT(`film_7`.`rt_audience`) + COUNT(`film_7`.`imdb`) ) AS `avg_7`, (COALESCE(`film_8`.`tomatometer`,0) + COALESCE(`film_8`.`rt_audience`,0) + COALESCE(`film_8`.`imdb`,0)) / ( COUNT(`film_8`.`tomatometer`) + COUNT(`film_8`.`rt_audience`) + COUNT(`film_8`.`imdb`) ) AS `avg_8`, (COALESCE(`film_9`.`tomatometer`,0) + COALESCE(`film_9`.`rt_audience`,0) + COALESCE(`film_9`.`imdb`,0)) / ( COUNT(`film_9`.`tomatometer`) + COUNT(`film_9`.`rt_audience`) + COUNT(`film_9`.`imdb`) ) AS `avg_9`, (COALESCE(`film_10`.`tomatometer`,0) + COALESCE(`film_10`.`rt_audience`,0) + COALESCE(`film_10`.`imdb`,0)) / ( COUNT(`film_10`.`tomatometer`) + COUNT(`film_10`.`rt_audience`) + COUNT(`film_10`.`imdb`) ) AS `avg_10`, (COALESCE(`film_11`.`tomatometer`,0) + COALESCE(`film_11`.`rt_audience`,0) + COALESCE(`film_11`.`imdb`,0)) / ( COUNT(`film_11`.`tomatometer`) + COUNT(`film_11`.`rt_audience`) + COUNT(`film_11`.`imdb`) ) AS `avg_11`, (COALESCE(`film_12`.`tomatometer`,0) + COALESCE(`film_12`.`rt_audience`,0) + COALESCE(`film_12`.`imdb`,0)) / ( COUNT(`film_12`.`tomatometer`) + COUNT(`film_12`.`rt_audience`) + COUNT(`film_12`.`imdb`) ) AS `avg_12` FROM `week` LEFT JOIN `films` AS `film_1` ON (`week`.`wheel_1` = `film_1`.`id`) LEFT JOIN `films` AS `film_2` ON (`week`.`wheel_2` = `film_2`.`id`) LEFT JOIN `films` AS `film_3` ON (`week`.`wheel_3` = `film_3`.`id`) LEFT JOIN `films` AS `film_4` ON (`week`.`wheel_4` = `film_4`.`id`) LEFT JOIN `films` AS `film_5` ON (`week`.`wheel_5` = `film_5`.`id`) LEFT JOIN `films` AS `film_6` ON (`week`.`wheel_6` = `film_6`.`id`) LEFT JOIN `films` AS `film_7` ON (`week`.`wheel_7` = `film_7`.`id`) LEFT JOIN `films` AS `film_8` ON (`week`.`wheel_8` = `film_8`.`id`) LEFT JOIN `films` AS `film_9` ON (`week`.`wheel_9` = `film_9`.`id`) LEFT JOIN `films` AS `film_10` ON (`week`.`wheel_10` = `film_10`.`id`) LEFT JOIN `films` AS `film_11` ON (`week`.`wheel_11` = `film_11`.`id`) LEFT JOIN `films` AS `film_12` ON (`week`.`wheel_12` = `film_12`.`id`) WHERE ( `moviegoer_1` = '9' OR `moviegoer_2` = '9' OR `moviegoer_3` = '9' OR `moviegoer_4` = '9' OR `moviegoer_5` = '9' OR `moviegoer_6` = '9' OR `moviegoer_7` = '9' OR `moviegoer_8` = '9' OR `moviegoer_9` = '9' OR `moviegoer_10` = '9' OR `moviegoer_11` = '9' OR `moviegoer_12` = '9' )  GROUP BY `week`.`id`
";

	$result = db($sql);

	//print_r($sql);
	$viewerPicks = Array();
	foreach($result as $anEvent){
		for($i = 1; $i <=12; $i++){
			if($anEvent["moviegoer_$i"] == $id && $anEvent["avg_$i"] != NULL){
				$viewerPicks[] = $anEvent["avg_$i"];
			}
		}
	}

	if(count($viewerPicks) == 0){
		return 0;
	}

	return round(array_sum($viewerPicks)/count($viewerPicks),2);
}

function find_best_or_worst_watched_film_with_year_option($best_or_worst = "best", $year = NULL){
	if($best_or_worst == "best"){
		$order = "DESC";
	} else {
		$order = "ASC";
	}

	if($year != NULL){
		$time1 = $year."-01-01";
		$time2 = $year."-12-31";
		$sql = "SELECT * FROM ( SELECT week.id, winning_film, films.name, (COALESCE(tomatometer, 0)+COALESCE(rt_audience, 0)+COALESCE(imdb, 0)) / ( COUNT(tomatometer) + COUNT(rt_audience) + COUNT(imdb) ) AS avg_rating FROM week LEFT JOIN films ON (week.winning_film = films.id) WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY id ORDER BY avg_rating $order ) AS `temp` WHERE `temp`.`avg_rating` IS NOT NULL";
	} else {
		$sql = "SELECT * FROM ( SELECT week.id, winning_film, films.name, (COALESCE(tomatometer, 0)+COALESCE(rt_audience, 0)+COALESCE(imdb, 0)) / ( COUNT(tomatometer) + COUNT(rt_audience) + COUNT(imdb) ) AS avg_rating FROM week LEFT JOIN films ON (week.winning_film = films.id) GROUP BY id ORDER BY avg_rating $order ) AS `temp` WHERE `temp`.`avg_rating` IS NOT NULL;";
	}
	//echo $sql;

	$result = db($sql);
	return $result;
}

function get_viewers_years($id){
	$events = getListOfEvents("ASC");
	$viewerPicks = Array();

	foreach($events as $anEvent){
		for($i = 1; $i <=12; $i++){
			$viewerPicks[$anEvent["moviegoer_$i"]][] = $anEvent["wheel_$i"];
		}
	}

	$viewerPicksUnique = Array();

	foreach($viewerPicks as $key => $value){
		$viewerPicksUnique[$key] = array_unique($value);
	}

	$viewerYears = Array();
	foreach($viewerPicksUnique as $key => $value){
		foreach($value as $film){
			$viewerYears[$key][] = get_movie_year($film);
		}
	}
	return $viewerYears[$id];
}


function get_viewers_years_single($id){
	$events = getListOfEvents("ASC");
	$viewerPicks = Array();
	foreach($events as $anEvent){
		for($i = 1; $i <=12; $i++){
			if($anEvent["moviegoer_$i"] == $id){
				$viewerPicks[] = $anEvent["wheel_$i"];
			}
		}
	}
	$viewerPicksUnique = array_unique($viewerPicks);

	$viewerYears = Array();
	foreach($viewerPicksUnique as $film){
			$viewerYears[] = get_movie_year($film);
	}
	return $viewerYears;
}


function get_moviegoer_from_wedge($number, $id){
	$column = "moviegoer_".$number;

	$sql = "SELECT `$column` FROM `week` WHERE `id` = $id";

	$result = db($sql);

	return $result[0][$column];

}

function last_spin_date($id){

	$sql = "SELECT `date` FROM `week` WHERE `spinner` = $id ORDER BY `date` ASC";

	$result = db($sql);

	if($result != NULL){
		return array_pop($result)['date'];
	}
}


function get_service_stats(){

	$sql = "SELECT `format`, COUNT(*) FROM `week` GROUP BY `format` ORDER BY COUNT(*) DESC";

	$result = db($sql);

	return $result;
}

function get_selector_stats(){

	$sql = "SELECT `selection_method`, COUNT(*) FROM `week` GROUP BY `selection_method` ORDER BY COUNT(*) DESC";

	$result = db($sql);

	return $result;
}

function first_run_add_winning_moviegoer(){

	/*$sql = "SELECT `id`, `winning_wedge` FROM `week`";
	$result = db($sql);
	//print_r($result);

	foreach($result as $week){
		$moviegoer = "moviegoer_".$week['winning_wedge'];
		$id = $week['id'];

		$sql2 = "SELECT `$moviegoer` FROM `week` WHERE `id` = '$id'";
		//echo $sql2;

		$result2 = db($sql2)[0]["$moviegoer"];
		//print_r($result2);

		$sql3 = "UPDATE `week` SET `winning_moviegoer` = $result2 WHERE `id` = '$id'";
		//echo $sql3;
		$result3 = db($sql3);
	}*/

}

function find_my_longest_streak($moviegoer){

	$sql = "SELECT `winning_moviegoer` FROM `week` ORDER BY `date`, `id` ASC";

	$results = db($sql);

	//print_r($results);

	$counter = 0;
	$max_counter = 0;

	foreach($results as $week){

		if($moviegoer == $week['winning_moviegoer']){
			$counter++;
		} else {
			if($counter > $max_counter){
				$max_counter = $counter;
				$counter = 0;
			} else {
				$counter = 0;
			}

		}

	}

	return $max_counter;

}

function get_dry_spell($moviegoer){

	$sql = "SELECT `date`, `winning_moviegoer`, `attendees` FROM `week` ORDER BY `date` ASC";

	$results = db($sql);

	//print_r($results);

	$attend_list = Array();

	foreach($results as $aweek){

		$attendees = explode(",", $aweek['attendees']);

		if(in_array($moviegoer, $attendees)){
			$attend_list[] = $aweek;
		}

	}

	$counter = 0;
	$max_counter = 0;

	$date_test = Array();

	foreach($attend_list as $anEvent){
		if($anEvent['winning_moviegoer']!=$moviegoer){
			$counter++;
			//echo $anEvent['date'] . " Lost ".$counter."<br />";
		} else{
			if($counter > $max_counter){
				$max_counter = $counter;
				$counter = 0;
				//echo $anEvent['date'] . " WON! <br />";
			} else {
				$counter = 0;
				//echo $anEvent['date'] . " WON! <br />";
			}
		}
	}

	if($counter > $max_counter){
		$max_counter = $counter;
	}

	return $max_counter;

}


function count_viewer_services($viewer_id){
	$sql = "SELECT `format`, COUNT(*) FROM `week` WHERE `winning_moviegoer` = '$viewer_id' GROUP BY `format`";

	$return = db($sql);

	$values = Array();

	if($return != NULL){
		foreach($return as $item){
			$values[$item['format']] = $item['COUNT(*)'];
		}
		arsort($values);
	}
	return $values;
}

function count_yearly_events($year){
	$time1 = $year."-01-01";
	$time2 = $year."-12-31";
	$sql = "SELECT COUNT(*) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";

	$return = db($sql);


	return $return[0]['COUNT(*)'];
}

function count_events(){

	$sql = "SELECT COUNT(*) FROM `week`";

	$return = db($sql);

	return $return[0]['COUNT(*)'];
}

function get_service_color($service_name = NULL){
	$colors = Array("Disney+" => "rgba(44,43,191,1)",
		"Netflix" => "rgba(229,9,20,1)",
		"Hulu" => "rgba(28,231,131,1)",
		"Digital File" => "rgba(237,182,23,1)",
		"DVD" => "rgba(166,170,155,1)",
		"Prime" => "rgba(0,168,255,1)",
		"HBO Max" => "rgba(91,28,230,1)",
		"iTunes Rental" => "rgba(136,136,136,1)",
		"Starz" => "rgba(0,0,0,1)",
		"HBO Now" => "rgba(0,0,0,1)",
		"Redbox" => "rgba(227,32,69,1)",
		"YouTube Movies" => "rgba(255,0,0,1)",
		"Bluray" => "rgba(0,144,206,1)",
		"Streaming" => "rgba(99,44,140,1)",
		"Steam" => "rgba(27,40,56,1)",
		"Apple TV+" => "rgba(11,11,12,1)",
		"Comedy Central" => "rgba(253,198,0,1)",
		"Showtime" => "rgba(177,0,0,1)");

	if($service_name == NULL){
		return $colors;
	}
		return $colors[$service_name];
}

function viewer_watchtime($year = null){
	if($year == null){
		$sql = "SELECT `runtime`, `attendees` FROM `week`";
	}

	$viewer_times = Array();
	$result = db($sql);

	foreach($result as $week){
		$attendees = explode(",",$week['attendees']);
		foreach($attendees as $viewer){
			if(isset($viewer_times[trim($viewer)])){
				$viewer_times[trim($viewer)] += $week['runtime'];
			} else {
				$viewer_times[trim($viewer)] = $week['runtime'];
			}
			
		}
	}

	return $viewer_times;
}


function add_page_load(){

	// Only connect to the database once.
	if(!isset($db)){
		$db = new mysqli(AT_DB_ADDR, AT_DB_USER, AT_DB_PASS, AT_DB_NAME);
		if($db === FALSE){return $db->connect_error();}
	}

	$today = new DateTime(date("Y-m-d"));
	$stringDate = $today->format("Y-m-d");

	$query = "INSERT INTO `movie` (`date`, `count`) VALUES ('$stringDate', 1) ON DUPLICATE KEY UPDATE count=count+1";

	// Execute a query if provided
	if(!empty($query)){
		$result = $db->query($query);
		// Stop if the DB errors
		if(!$result){
			return FALSE;
			// return $result->error;
		}
		// Format returned rows into an array
		elseif(stripos($query, 'SELECT') !== FALSE) {
			$return = Array();
			while($row = $result->fetch_assoc()){
				$return[] = $row;
			}
			return (sizeof($return)) ? $return : FALSE;
		}
		else {
			return $result;
		}
	}
	// If all else fails, return the database resource
	return $db;
}

function echoVersionNumber(){
	echo "3.1.4";
	return;
}
?>
