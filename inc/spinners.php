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


?>
