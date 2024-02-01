<?php

function get_movie_by_id($pdo, $id) {
	$stmt = $pdo->prepare('SELECT name FROM films WHERE id = ?');
	$stmt->execute([ $id ]);
	$name = $stmt->fetchColumn();
	return $name;
}

function get_type_by_id($pdo, $id) {
	$stmt = $pdo->prepare('SELECT type FROM films WHERE id = ?');
	$stmt->execute([ $id ]);
	$name = $stmt->fetchColumn();
	return $name;
}

function get_movie_list($pdo) {
	$stmt = $pdo->prepare('SELECT * FROM films WHERE id != 0 ORDER BY name ASC');
	$stmt->execute();
	$list = $stmt->fetchAll();
	return $list;
}

function get_movie_runtime($pdo, $film_id) {
	$stmt = $pdo->prepare('SELECT runtime FROM films WHERE id = ?');
	$stmt->execute([ $film_id ]);
	$runtime = $stmt->fetchColumn();
	return $runtime;
}


function count_scribing($pdo, $id) {
	$stmt = $pdo->prepare('SELECT count(*) FROM week WHERE scribe = ?');
	$stmt->execute([ $id ]);
	$count = $stmt->fetchColumn();
	return $count;
}


function listMyTotalPicksReal($id) {
	$weeks = getListOfEvents();
	$allMyPicks = [];
	foreach ($weeks as $aWeek) {
		$allMyPicks = array_merge($allMyPicks, myMoviePicksForWeekID($aWeek['id'], $id));
	}
	return $allMyPicks;
}

function myMoviePicksForWeekID($id, $viewerID) {
	$sql = "SELECT * FROM `week` WHERE `id` = '{$id}' ORDER BY `date` ASC";
	$data = db($sql)[0];
	//print_r($data);
	$returnMe = [];
	for ($i = 1; $i < 13; $i++) {
		$movieID = $data["wheel_$i"];
		$pickerID = $data["moviegoer_$i"];
		if ($pickerID == $viewerID) {
			$returnMe[] = [ "filmID" => $movieID, "moviegoerID" => $pickerID ];
		}
	}
	return $returnMe;
}
