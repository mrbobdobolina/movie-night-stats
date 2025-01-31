<?php

function get_raw_showing_data($pdo, $number){
  $stmt = $pdo->prepare('SELECT * FROM showings WHERE event_number = ?');
	$stmt->execute([$number]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function get_all_showing_data($pdo){
  $stmt = $pdo->prepare('SELECT * FROM showings ORDER BY event_number ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_event_count($pdo){
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM showings');
	$stmt->execute();
	$result = $stmt->fetchColumn();
	return $result;
}

function reorder_event_numbers($pdo){
  $stmt = $pdo->prepare('SELECT id, date FROM showings ORDER BY date, id ASC');
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $i = 1;
  foreach($result as $event){
    $stmt = $pdo->prepare('UPDATE showings SET event_number = ? WHERE date = ? AND id = ?');
  	$stmt->execute([$i, $event['date'], $event['id']]);
  	$i++;
  }
}

function get_showing_data($pdo, $number){
  $stmt = $pdo->prepare('SELECT * FROM showings WHERE event_number = ?');
	$stmt->execute([$number]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function get_film_array($pdo, $data){
  $film_ids = Array();
  for($i=1; $i<=12; $i++){
    if($data['wheel_'.$i]){
      $film_ids[] = $data['wheel_'.$i];
    }
  }

  $film_ids = array_unique($film_ids);
  $film_ids = array_values($film_ids);
  $placeholder = str_repeat('id = ? OR ', count($film_ids) - 1) . " id = ?";
  $sql = "SELECT * FROM films WHERE ($placeholder)";
  $stmt = $pdo->prepare($sql);
	$stmt->execute($film_ids);
	//$result = $stmt->fetchAll();

  $items = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $items[$row['id']] = $row; // Use 'id' as the key
  }
	return $items;
}

function get_cast_list($pdo){
  $stmt = $pdo->prepare('SELECT * FROM viewers');
  $stmt->execute();
  $items = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $items[$row['id']] = $row; // Use 'id' as the key
  }
  return $items;
}

function update_attendance($pdo){
  //zeros out table before recalculating
  $stmt = $pdo->prepare('TRUNCATE TABLE attendance');
  $stmt->execute();
  $stmt = $pdo->prepare('SELECT date, attendees FROM week ORDER BY date ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();

  foreach($result as $item){
    $list = explode(", ", $item['attendees']);
    foreach($list as $person){
      $stmt = $pdo->prepare('INSERT INTO attendance (event_date, user_id) VALUES (?, ?)');
    	$stmt->execute([$item['date'], $person]);
    }
  }
	return $result;
}

/**
 * @param int $number
 * @return string
 */
function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}
