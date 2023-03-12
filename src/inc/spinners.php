<?php

function getSelectionTypes($get_all = FALSE){
	if($get_all == FALSE){
		$sql = "SELECT `name` FROM `spinners` WHERE `uses` > 0";
	} else {
		$sql = "SELECT `name` FROM `spinners`";
	}
	$data = db($sql);
	$tools = Array();
	foreach($data as $method){
		$tools[] = $method['name'];
	}
	//asort($tools);
	return $tools;
}

function get_moviegoers_from_this_wedge($pdo, $wedge_number){

	$query = "SELECT moviegoer_$wedge_number FROM week";

	$stmt = $pdo->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
	$people = Array();

	foreach($result as $a_person){
		if(array_key_exists($a_person,$people)){
			$people[$a_person]++;
		} else {
			$people[$a_person] = 1;
		}

	}

	return $people;
}

function get_movies_from_this_wedge($pdo, $wedge_number){

	$query = "SELECT wheel_$wedge_number FROM week";

	$stmt = $pdo->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

	return $result;
}

function get_viewers_time($pdo){
	$stmt = $pdo->prepare("SELECT * FROM week");
	$stmt->execute();
	$result = $stmt->fetchAll();

	$viewers_total_time = Array();

	foreach($result as $week){
		for($i = 1; $i <= 12; $i++){
			if(array_key_exists($week['moviegoer_'.$i],$viewers_total_time)){
				$viewers_total_time[$week['moviegoer_'.$i]] += get_movie_runtime($pdo, $week['wheel_'.$i]);
			} else {
				$viewers_total_time[$week['moviegoer_'.$i]] = get_movie_runtime($pdo, $week['wheel_'.$i]);
			}
		}
	}
	return $viewers_total_time;
}


