<?php

function getListOfViewers($sortBy = 'id', $direction = "DESC"){
	$sql = "SELECT * FROM `viewers` ORDER BY `$sortBy` $direction";
	$data = db($sql);

	return $data;
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
	$data = db($sql)[0]['color'];

	return $data;
}


function getViewerName($id){
	return getMoviegoerById($id);
}

?>
