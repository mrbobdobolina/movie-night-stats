<?php

function getListOfViewers($sortBy = 'id', $direction = "DESC"){
	$sql = "SELECT * FROM `viewers` ORDER BY `$sortBy` $direction";
	$data = db($sql);

	return $data;
}

function get_list_of_viewers($pdo, $sort_by = 'id', $direction = 'DESC'){
	$sql = "SELECT * FROM viewers ORDER BY ? $direction";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$sort_by]);
	$result = $stmt->fetchAll();
	return $result;
}

function getMoviegoerById($id){
	$sql = "SELECT `name` FROM `viewers` WHERE `id` = $id";
	$data = db($sql);

	if($data){
		return $data[0]['name'];
	}

	return null;
}

function getMoviegoerColorById($id){
	$sql = "SELECT `color` FROM `viewers` WHERE `id` = $id";
	$data = db($sql)[0]['color'];

	return $data;
}

function getMoviegoerColorByName($name){
	$sql = "SELECT `color` FROM `viewers` WHERE `name` = '$name'";
	$data = db($sql);

	if($data != NULL){
		return $data[0]['color'];
	}

	return "000000";
}


function getViewerName($id){
	return getMoviegoerById($id);
}

?>
