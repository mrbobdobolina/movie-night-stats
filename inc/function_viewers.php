<?php

function get_viewer_films($pdo){
  $stmt = $pdo->prepare('SELECT
    viewer,
    COUNT(DISTINCT date) AS unique_dates,
    COUNT(DISTINCT film) AS unique_films,
    COUNT(film) AS total_films
    FROM
        picks
    GROUP BY
        viewer
    ORDER BY
        viewer;');
	$stmt->execute();
	$result = $stmt->fetchAll();
  $data = Array();
  foreach($result as $viewer){
    $data[$viewer['viewer']] = $viewer;
  }
	return $data;
}

function get_atnd_cast($pdo){
  $stmt = $pdo->prepare('SELECT
    event_date,
    GROUP_CONCAT(DISTINCT user_id ORDER BY user_id) AS user_ids
    FROM attendance
    GROUP BY event_date
    ORDER BY event_date;
    ');
	$stmt->execute();
	$result = $stmt->fetchAll();

  $return_me = Array();

  foreach($result as $item){
    $return_me[$item['event_date']] = $item['user_ids'];
  }
	return $return_me;
}

function get_cast_member($pdo, $id){
  $stmt = $pdo->prepare('SELECT * FROM viewers WHERE id = ?');
	$stmt->execute([$id]);
	$result = $stmt->fetch();
	return $result;
}

function get_cast_atnd($pdo, $id){
  $stmt = $pdo->prepare('SELECT event_date FROM attendance WHERE user_id = ? ORDER BY event_date ASC');
	$stmt->execute([$id]);
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
	return $result;
}

function get_cast_picks($pdo, $id){
  $stmt = $pdo->prepare('SELECT
    viewer,
    COUNT(DISTINCT date) AS unique_dates,
    COUNT(DISTINCT film) AS unique_films,
    COUNT(film) AS total_films
    FROM
        picks
    WHERE viewer = ?
    GROUP BY
        viewer
    ORDER BY
        viewer;');
  $stmt->execute([$id]);
  $result = $stmt->fetch();
  return $result;
}

function get_pick_details($pdo, $id){
  $stmt = $pdo->prepare('SELECT p.*, f.*
    FROM picks p
    INNER JOIN films f ON p.film = f.id
    WHERE p.viewer = ?;');
	$stmt->execute([$id]);
	$result = $stmt->fetchAll();
	return $result;
}

function get_cast_stats($pdo, $id){
  $stmt = $pdo->prepare('SELECT
    COUNT(CASE WHEN winning_moviegoer = ? THEN 1 END) AS wins,
    COUNT(CASE WHEN spinner = ? THEN 1 END) AS spins,
    COUNT(CASE WHEN scribe = ? THEN 1 END) AS scribe
    FROM showings');
	$stmt->execute([$id,$id,$id]);
	$result = $stmt->fetch();
	return $result;
}

function get_cast_wheel($pdo, $id){
  $stmt = $pdo->prepare('SELECT * FROM showings WHERE spinner = ?');
	$stmt->execute([$id]);
	$result = $stmt->fetchAll();
  $data = Array("numbers" => Array(), "people" => Array(), "methods" => Array(), "services" => Array());
  $data['numbers'] = array_fill_keys(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', ], 0);
  foreach($result as $row){
    //update winning numbers
    if(!isset($data['numbers'][$row['winning_wedge']])){
      $data['numbers'][$row['winning_wedge']] = 1;
    } else {
      $data['numbers'][$row['winning_wedge']]++;
    }
    //update people spun
    if(!isset($data['people'][$row['winning_moviegoer']])){
      $data['people'][$row['winning_moviegoer']] = 1;
    } else {
      $data['people'][$row['winning_moviegoer']]++;
    }
    //update spin method
    if(!isset($data['methods'][$row['selection_method']])){
      $data['methods'][$row['selection_method']] = 1;
    } else {
      $data['methods'][$row['selection_method']]++;
    }
    //update services
    if(!isset($data['services'][$row['format']])){
      $data['services'][$row['format']] = 1;
    } else {
      $data['services'][$row['format']]++;
    }
  }
	return $data;
}

function get_unwatched_films($pdo, $user_id = 0){
  if($user_id != 0){
    $stmt = $pdo->prepare('SELECT f.id, f.name, f.wins, COUNT(p.film) AS pick_count
      FROM picks p
      JOIN films f ON p.film = f.id
      WHERE p.viewer = ?
      GROUP BY p.film
      ORDER BY pick_count DESC;');
  	$stmt->execute([$user_id]);
  	$result = $stmt->fetchAll();
  	return $result;
  }
}
