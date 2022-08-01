<?php

function get_movie_by_id($pdo, $id){
	$stmt = $pdo->prepare('SELECT name FROM films WHERE id = ?');
	$stmt->execute([$id]);
	$name = $stmt->fetchColumn();
	return $name;
}

function get_movie_list($pdo){
	$stmt = $pdo->prepare('SELECT * FROM films WHERE id != 0 ORDER BY name ASC');
	$stmt->execute();
	$list = $stmt->fetchAll();
	return $list;
}

function count_movie_list($pdo){
	$count = $pdo->query('SELECT count(*) FROM films')->fetchColumn();
	//we subtract one from the total count because db contains a null field for id = 0...
	//I'm sure there's a good reason for this.
	return $count - 1;
}

function count_total_film_appearances($pdo, $film_id){
	$counter = 0;
	for($i = 1; $i <= 12; $i++){
		$sql = "SELECT count(*) FROM week WHERE wheel_".$i." = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$film_id]);
		$counter += $stmt->fetchColumn();
	}
	return $counter;
}

//This function isn't being called currently...
/*function getMyMovieYears($id){
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
}*/

/*function getMovieRating($id){

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
}*/

function get_movie_year($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT year FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$result = $stmt->fetchColumn();
	return $result;
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

function count_attendance($pdo, $viewer_id){
	$stmt = $pdo->prepare('SELECT attendance FROM viewers WHERE id = ?');
	$stmt->execute([$viewer_id]);
	$result = $stmt->fetchColumn();
	return $result;
}

function count_all_attendance_v2($pdo){
	$stmt = $pdo->prepare("SELECT attendees FROM week");
	$stmt->execute();
	$list = $stmt->fetchAll();

	$attendees_count = Array();

	foreach($list as $row){
		$people = explode(", ", $row['attendees']);

		foreach($people as $person){
			if(array_key_exists($person,$attendees_count)){
				$attendees_count[$person]++;
			} else {
				$attendees_count[$person] = 1;
			}
		}
	}

	return $attendees_count;
}

function count_scribing($pdo, $id){
	$stmt = $pdo->prepare('SELECT count(*) FROM week WHERE scribe = ?');
	$stmt->execute([$id]);
	$count = $stmt->fetchColumn();
	return $count;
}

function count_total_picks_for_everyone($pdo){
	$stmt = $pdo->prepare('SELECT * FROM week');
	$stmt->execute();
	$week_list = $stmt->fetchAll();

	$attendee_pick_list = Array();

	foreach($week_list as $week){
		for($i = 1; $i <= 12; $i++){
			if(array_key_exists($week['moviegoer_'.$i], $attendee_pick_list)){
				$attendee_pick_list[$week['moviegoer_'.$i]][] = $week['wheel_'.$i];
			} else {
				$attendee_pick_list[$week['moviegoer_'.$i]] = Array($week['wheel_'.$i]);
			}
		}
	}
	//print_r($attendee_pick_list);
	$attendee_pick_count = Array();

	foreach($attendee_pick_list as $key => $attendee){
		$attendee_pick_count[$key] = Array("total" => count($attendee), "unique" => count(array_unique($attendee)));
	}

	return $attendee_pick_count;
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

function get_movie_avg_rating($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT (COALESCE(tomatometer,0)+COALESCE(rt_audience,0)+COALESCE(imdb,0)) / ( COUNT(tomatometer) + COUNT(rt_audience) + COUNT(imdb) ) FROM films WHERE  id = ?');
	$stmt->execute([$film_id]);
	$result = $stmt->fetchColumn();
	return round($result, 1)."%";
}

function get_MPAA($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT MPAA FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$result = $stmt->fetchColumn();
	return $result;
}

function get_movie_poster($film_id){
	$sql = "SELECT `poster_url` FROM `films` WHERE `id` = $film_id";

	$result = db($sql);

	if($result[0]['poster_url']!= ""){
		return $result[0]['poster_url'];
	}

	$movie_info_url = "http://www.omdbapi.com/?t=".str_replace(" ","+",get_movie_by_id($pdo,$film_id))."&y=".get_movie_year($pdo,$film_id)."&apikey=".OMDB_API_KEY;
	$movie_info = json_decode(file_get_contents($movie_info_url), true);

	if($movie_info['Response'] == "True"){
		$poster_url = $movie_info['Poster'];
		$imdb_id = $movie_info['imdbID'];

		$sql = "UPDATE `films` SET `poster_url` = '$poster_url', `imdb_id` = '$imdb_id' WHERE `id` = $film_id";
		db($sql);

		return $poster_url;
	} else {
		return "https://via.placeholder.com/400x600/333/fff?text=".str_replace(" ","+",get_movie_by_id($pdo,$film_id));
	}

}

function get_movie_poster_v3($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT poster_url FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$poster = $stmt->fetchColumn();

	if($poster != ""){
		return $poster;
	} else {
		return "https://via.placeholder.com/400x600/333/fff?text=".str_replace(" ","+",get_movie_by_id($pdo,$film_id));
	}
}

?>
