<?php

function get_spin_numbers($pdo, $include_errors = FALSE, $include_vc = FALSE){
  if($include_errors == TRUE && $include_vc == TRUE){
    $stmt = $pdo->prepare('SELECT winning_wedge, error_spin FROM showings');
    $stmt->execute();
  } elseif($include_errors == TRUE && $include_vc == FALSE) {
    $stmt = $pdo->prepare('SELECT winning_wedge, error_spin FROM showings WHERE selection_method != ?');
    $stmt->execute(['viewer choice']);
  } elseif($include_errors == FALSE && $include_vc == TRUE) {
    $stmt = $pdo->prepare('SELECT winning_wedge FROM showings');
    $stmt->execute();
  } elseif($include_errors == FALSE && $include_vc == FALSE) {
    $stmt = $pdo->prepare('SELECT winning_wedge FROM showings WHERE selection_method != ?');
    $stmt->execute(['viewer choice']);
  }

	$result = $stmt->fetchAll();
	return $result;
}

function get_spinner_histogram($pdo){
  $stmt = $pdo->prepare('SELECT name, uses FROM spinners ORDER BY uses DESC');
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}

function get_spinner_types($pdo){
  $stmt = $pdo->prepare('SELECT name FROM spinners');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_spinner_data($pdo){
  $stmt = $pdo->prepare('SELECT winning_wedge, selection_method FROM showings ORDER BY selection_method ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}
