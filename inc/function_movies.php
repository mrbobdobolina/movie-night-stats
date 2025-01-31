<?php

function get_movie_info($pdo, $movie_id){
  $stmt = $pdo->prepare('SELECT * FROM films WHERE id = ?');
	$stmt->execute([$movie_id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function get_movie_genres($pdo, $movie_id){
  $stmt = $pdo->prepare('SELECT genre FROM film_genres WHERE film_id = ?');
	$stmt->execute([$movie_id]);
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
	return $result;
}

function count_films($pdo){
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM films');
	$stmt->execute();
	$result = $stmt->fetchColumn();
	return $result-1;
  //Currently the DB has an empty array with an ID of zero. (So that's why we subtract 1.)
}

function get_movie_events($pdo, $film_id){
  $stmt = $pdo->prepare('SELECT * FROM showings WHERE wheel_1 = ? OR wheel_2 = ? OR wheel_3 = ? OR wheel_4 = ? OR wheel_5 = ? OR wheel_6 = ? OR wheel_7 = ? OR wheel_8 = ? OR wheel_9 = ? OR wheel_10 = ? OR wheel_11 = ? OR wheel_12 = ? ORDER BY date ASC');
	$stmt->execute([$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id,$film_id]);
	$result = $stmt->fetchAll();

  $result['counts'] = count_movie_wheels_and_wedges($film_id, $result);

  if($result){
    if($result[0]['winning_film'] == $film_id){
      $result['ohw'] = TRUE;
    } else {
      $result['ohw'] = FALSE;
    }
  }

	return $result;
}

function count_movie_wheels_and_wedges($movie_id, $data){
  $wheelCount = 0;
  $wedgeCount = 0;
  $wins = 0;
  foreach($data as $item){
    $c = 0;
    if($item['winning_film'] == $movie_id){
      $wins++;
    }
    for($i = 1; $i <= 12; $i++){
      if($item['wheel_'.$i] == $movie_id){
        $c++;
      }
    }
    if($c > 0){
      $wheelCount++;
      $wedgeCount = $wedgeCount + $c;
    }

  }
  return Array("wheel" => $wheelCount, "wedges" => $wedgeCount, "wins" => $wins);
}

function calculate_average($array){
  if(count($array) == 0){
    return 0;
  } else {
    return round((array_sum($array)/count($array)));
  }
}

function get_all_films($pdo){
  $stmt = $pdo->prepare('SELECT * FROM films WHERE id != ? ORDER BY name ASC');
	$stmt->execute([0]);
	$result = $stmt->fetchAll();
	return $result;
}

function get_film_names($pdo){
  $stmt = $pdo->prepare('SELECT id, name FROM films WHERE id != ? ORDER BY name ASC');
	$stmt->execute([0]);
	$result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	return $result;
}

function get_film_pickers($pdo, $film_id){
  $stmt = $pdo->prepare('SELECT viewer, COUNT(*) AS film_count FROM picks WHERE film = ? GROUP BY viewer ORDER BY film_count DESC');
	$stmt->execute([$film_id]);
	$result = $stmt->fetchAll();
	return $result;
}

function update_films_table($pdo){
  //zeros out columns before recalculating
  $stmt = $pdo->prepare('UPDATE films SET wins = ?, wedges = ?, x_on_wheel = ?');
	$stmt->execute([0, 0, 0]);
  $stmt = $pdo->prepare('SELECT * FROM showings ORDER BY event_number ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();

  foreach($result as $event){
    $stmt2 = $pdo->prepare('UPDATE films SET wins = wins + 1 WHERE id = ?');
    $stmt2->execute([$event['winning_film']]);

    $week_array = Array();
    for ($i = 1; $i <= 12; $i++) {
      $stmt3 = $pdo->prepare('UPDATE films SET wedges = wedges + 1 WHERE id = ?');
      $stmt3->execute([$event['wheel_'.$i]]);
      $week_array[] = $event['wheel_'.$i];
    }

    $unique = array_unique($week_array);
    if($unique){
      foreach ($unique as $value) {
        $stmt3 = $pdo->prepare('UPDATE films SET x_on_wheel = x_on_wheel + 1 WHERE id = ?');
        $stmt3->execute([$value]);
      }
    }
    unset($week_array);
  }
}

function update_films_ohw($pdo){
  $stmt = $pdo->prepare('SELECT date, winning_film FROM showings');
	$stmt->execute();
	$result = $stmt->fetchAll();

  foreach($result as $event){
    $stmt2 = $pdo->prepare('SELECT * FROM films WHERE id = ?');
  	$stmt2->execute([$event['winning_film']]);
  	$result2 = $stmt2->fetch();

    if($result2['first_instance'] == $event['date']){
      $stmt3 = $pdo->prepare('UPDATE films SET ohw = ? WHERE id = ?');
    	$stmt3->execute([1,$event['winning_film']]);
    }
  }
}

function populate_picks_table($pdo){
  //zeros out table before recalculating
  $stmt = $pdo->prepare('TRUNCATE TABLE showings');
  $stmt->execute();
  $stmt = $pdo->prepare('SELECT * FROM showings');
	$stmt->execute();
	$result = $stmt->fetchAll();

  foreach($result as $event){
    for ($i = 1; $i <= 12 ; $i++) {
      if($event['moviegoer_'.$i] != 0){
        $stmt2 = $pdo->prepare('INSERT INTO picks (date, viewer, wedge, film) VALUES (?, ?, ?, ?)');
        $stmt2->execute([$event['date'], $event['moviegoer_'.$i], $i, $event['wheel_'.$i]]);
      }

    }
  }
}

function get_film_name($pdo, $film_id){
  $stmt = $pdo->prepare('SELECT name FROM films WHERE id = ?');
	$stmt->execute([$film_id]);
	$result = $stmt->fetch(PDO::FETCH_COLUMN);
	return $result;
}
