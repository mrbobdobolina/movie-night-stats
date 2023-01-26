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

function get_movie_runtime($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT runtime FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$runtime= $stmt->fetchColumn();
	return $runtime;
}


function get_movie_year($pdo, $film_id){
	$stmt = $pdo->prepare('SELECT year FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$result = $stmt->fetchColumn();
	return $result;
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


