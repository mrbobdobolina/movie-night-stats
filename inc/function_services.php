<?php

function get_service_list($pdo){
  $stmt = $pdo->prepare('SELECT * FROM services');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_service_wins($pdo){
  $stmt = $pdo->prepare('SELECT format, runtime FROM showings');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_service_colors($pdo){
  $stmt = $pdo->prepare('SELECT name, rgba FROM services');
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
  return $result;
}

function get_service_win_and_time($pdo){
  $stmt = $pdo->prepare('SELECT format, COUNT(*) as count, SUM(runtime) as total_runtime FROM showings GROUP BY format ORDER BY count DESC');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_winning_films_and_services($pdo){
  $stmt = $pdo->prepare('SELECT s.date, f.name AS winning_film_name, s.format FROM showings s JOIN films f ON s.winning_film = f.id ORDER BY s.date ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}
