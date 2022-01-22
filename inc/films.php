<?php

function getMovieById($id){
	$sql = "SELECT `name` FROM `films` WHERE `id` = $id";
	$data = db($sql)[0]['name'];

	return $data;
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

function countTotalFilmApperances($filmID){

	$counter = 0;

	for($i = 1; $i <= 12; $i++){
		$sql = "SELECT COUNT(*) AS `count` FROM `week` WHERE `wheel_$i` = $filmID";
		$data = db($sql)[0]['count'];

		$counter = $counter + $data;
	}

	return $counter;
}

function getMyMovieYears($id){
	$myList = listMyTotalPicksReal($id);
	$myUnique = array_column($myList, 'filmID');

	$yearList = Array();

	foreach($myUnique as $aFilmID){

		$sql = "SELECT `year` FROM `films` WHERE `id` = '$aFilmID'";
		$result = db($sql);

		$yearList[] = $result[0]['year'];
	}

	$yearList = array_filter(array_unique($yearList));



	return round(array_sum($yearList)/count($yearList));
	//return $yearList;
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

function get_movie_year($filmID){
	$sql = "SELECT `year` FROM `films` WHERE `id` = $filmID";
	$result = db($sql)[0];


	return $result['year'];
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
	return $values[$id] ?? 0;

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

function getMovieRatingReal($id){
	$sql = "SELECT (COALESCE(`tomatometer`,0)+COALESCE(`rt_audience`,0)+COALESCE(`imdb`,0)) / ( COUNT(`tomatometer`) + COUNT(`rt_audience`) + COUNT(`imdb`) ) AS `avg_rating` , `films`.`name` FROM  `films` WHERE  `id` = '$id'";
	$result = db($sql);

	return round($result[0]['avg_rating'], 1)."%";
}

function getMovieMPAA($id){
	$sql = "SELECT `MPAA` FROM `films` WHERE `id` = $id";
	$data = db($sql)[0]['MPAA'];

	return $data;
}

?>
