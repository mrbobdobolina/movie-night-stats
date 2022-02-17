<?php
require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(!defined('ROOT')){
	define('ROOT', dirname( __FILE__ ) . '/');
}

// Check if settings file exists
if(file_exists(ROOT.'settings.config')){
	// It Does!
	require ROOT.'settings.config';
}
else {
	// No Settings file. Redirect to an error page
	header('Location: ./init/error.php?e=settings.cfg');
	die();
}

$numberTypes = Array("arabic", "roman", "japanese", "arabic", "roman");


include(ROOT.'inc/db.php');

//check DB Version
if(read_db_version() != this_db_version()){
	header('Location: ./init/error.php?e=oldDB');
	die();
}

// Includes a file from the template directory
function template($part){
	require_once(ROOT.'template/'.$part.'.php');
}



include(ROOT.'inc/films.php');
include(ROOT.'inc/spinners.php');
include(ROOT.'inc/viewers.php');
include(ROOT.'inc/week.php');



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

function biggest_winner($year){
	$winners = winners_by_year($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top_winners' => $top_winners, 'count' => $max);
}

function biggest_spinner($year){
	$winners = spins_by_year($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top_spinner' => $top_winners, 'count' => $max);
}

function biggest_blank($year, $blank, $ignore_viewer_choice = FALSE){
	$winners = blank_by_year($year, $blank, $ignore_viewer_choice);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top' => $top_winners, 'count' => $max);
}

function highest_attendance($year){
	$winners = yearly_viewer_attendance($year);
	$max = max($winners);
	$top_winners = array_keys($winners, $max);
	return Array('top' => $top_winners, 'count' => $max);
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

function get_freshness($array){
	return round((array_sum($array)/(count(array_filter($array))*100))*100, 0);
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


//Legacy Function... I think we can delete this? But I'm leaving it here for now.
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
		"Showtime" => "rgba(177,0,0,1)",
		"Tubi" => "rgb(255,80,26,1)");

	if($service_name == NULL){
		return $colors;
	}
		return $colors[$service_name];
}

/**
* Returns either list of services with colors or just the color of a given service
* @param optional $service_name = NULL
* @return array of services
* OR
* @param optional $service_name = string
* @return string with rgba color
*/
function get_service_color_v3($service_name = NULL){
	if($service_name == NULL){
		$sql = "SELECT `name`, `rgba` FROM `services`";
		$result = db($sql);
		foreach($result as $service){
			$colors[$service['name']] = $service['rgba'];
		}
		return $colors;
	} else {
		$sql = "SELECT `rgba` FROM `services` WHERE `name` = '$service_name'";
		$colors = db($sql);
		return $colors[0]['rgba'];
	}
}

function getListOfServices($sortBy = 'id', $direction = "DESC"){
	$sql = "SELECT * FROM `services` ORDER BY `$sortBy` $direction";
	$data = db($sql);

	return $data;
}

//reads the db version listed in the DB
function read_db_version(){
	$sql = "SELECT * FROM `options` WHERE `name` = 'db_version'";
	$result = db($sql);
	return $result[0]['value'];
}

//the db version used by the site right now
function this_db_version(){
	return "3.2";
}

function echoVersionNumber(){
	echo "3.6.1";
	return;
}

?>
