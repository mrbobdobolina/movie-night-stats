<?php

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

?>
