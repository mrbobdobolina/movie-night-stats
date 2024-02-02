<?php

/**
 * Returns multidimensional array of all information in week table
 *
 * @param optional string $direction to indicate which way to sort, default ascending
 *
 * @return array of events
 */
function getListOfEvents($direction = "ASC") {
	$sql = "SELECT * FROM `week` ORDER BY `date` $direction, `id` DESC";
	$data = db($sql);

	return $data;
}

function get_single_event($id) {
	$sql = "SELECT * FROM `week` WHERE `id` = $id";
	$data = db($sql)[0];

	return $data;
}

function countSpins() {
	$sql = "SELECT COUNT(*) AS `total` FROM `week`";
	$data = db($sql)[0]['total'];
	return $data;
}

function countErrorSpins() {
	$sql = "SELECT `error_spin` from `week` WHERE `error_spin` != ''";
	$data = db($sql);

	$error_spins = 0;

	foreach ($data as $errors) {
		$error_spins += count(explode(",", $errors['error_spin']));
	}

	return ( $error_spins );
}

function getErrorSpins() {
	$sql = "SELECT `error_spin` from `week` WHERE `error_spin` != ''";
	$data = db($sql);

	$error_spins = [];

	foreach ($data as $errors) {
		$list = explode(",", $errors['error_spin']);

		if (count($list) > 1) {
			foreach ($list as $item) {
				$error_spins[] = str_replace(" ", "", $item);
			}
		}
		else {
			$error_spins[] = str_replace(" ", "", $list[0]);
		}
	}

	$histogram = [];

	for ($i = 1; $i <= 12; $i++) {
		$histogram[$i] = 0;
	}

	foreach ($error_spins as $value) {
		$histogram[$value]++;
	}

	return $histogram;
}


function countWinsForNumber($number) {
	$sql = "SELECT COUNT(*) AS `total` FROM `week` WHERE `winning_wedge` = $number";
	$data = db($sql)[0]['total'];
	return $data;
}

function getNumbersFromTool($tool) {
	$sql = "SELECT `winning_wedge` FROM `week` WHERE `selection_method` = '$tool'";
	$data = db($sql);
	$count = count($data);

	$histogram = makeHistogram($data);

	return $histogram;
}

function listWatchedMovies() {
	$sql = "SELECT `winning_film` FROM `week`";
	$data = db($sql);
	$list = array_column($data, "winning_film");

	return array_unique($list);
}

function calculateTotalWatchtime() {
	$sql = "SELECT SUM(runtime) AS runtime FROM `week`";
	$totalMinutes = db($sql)[0]['runtime'];

	return $totalMinutes;
}

function calculateYearlyWatchtime($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT SUM(runtime) AS runtime FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$totalMinutes = db($sql)[0]['runtime'];
	return $totalMinutes;
}

function calculate_attendance($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT `attendees` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$total_attending = db($sql);
	//print_r($total_attending);

	$total = 0;
	foreach ($total_attending as $value) {
		$total += count(explode(',', $value['attendees']));
	}

	return $total;
}


function winners_by_year($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT `winning_moviegoer`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `winning_moviegoer`";
	$winners = db($sql);
	$win = [];
	foreach ($winners as $a_winner) {
		$win[$a_winner['winning_moviegoer']] = $a_winner['COUNT(*)'];
	}
	return $win;
}

function spins_by_year($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT `spinner`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `spinner`";
	$winners = db($sql);
	$win = [];
	foreach ($winners as $a_winner) {
		$win[$a_winner['spinner']] = $a_winner['COUNT(*)'];
	}
	return $win;
}

function blank_by_year($year, $blank, $ignore_viewer_choice = FALSE) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	if ($ignore_viewer_choice == TRUE) {
		$sql = "SELECT `$blank`, COUNT(*) FROM `week` WHERE `selection_method` != 'viewer choice' AND `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `$blank`";
	}
	else {
		$sql = "SELECT `$blank`, COUNT(*) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `$blank`";
	}

	$winners = db($sql);

	$win = [];
	foreach ($winners as $a_winner) {
		$win[$a_winner[$blank]] = $a_winner['COUNT(*)'];
	}

	return $win;
}

function count_minutes_per_service($year = NULL) {
	if ($year == NULL) {
		$sql = "SELECT `format`, SUM(`runtime`) FROM `week` GROUP BY `format` ORDER BY SUM(`runtime`) DESC";
	}
	else {
		$time1 = $year . "-01-01";
		$time2 = $year . "-12-31";
		$sql = "SELECT `format`, SUM(`runtime`) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY `format` ORDER BY SUM(`runtime`) DESC";
	}
	$result = db($sql);

	return $result;
}

function yearly_viewer_attendance($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT `attendees` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$array = db($sql);
	//print_r($array);
	$full_list = [];
	foreach ($array as $value) {
		//print_r($value);
		$new = explode(',', $value['attendees']);
		foreach ($new as $v2) {
			if (isset($full_list[trim($v2)])) {
				$full_list[trim($v2)]++;
			}
			else {
				$full_list[trim($v2)] = 1;
			}
		}
	}

	arsort($full_list);
	return $full_list;

}

function most_requested_film($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT `wheel_1`,`wheel_2`,`wheel_3`,`wheel_4`,`wheel_5`,`wheel_6`,`wheel_7`,`wheel_8`,`wheel_9`,`wheel_10`,`wheel_11`,`wheel_12` FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";
	$array = db($sql);
	$movieList = [];
	foreach ($array as $list) {
		foreach ($list as $movie) {
			if (isset($movieList[$movie])) {
				$movieList[$movie]++;
			}
			else {
				$movieList[$movie] = 1;
			}

		}
	}
	unset($movieList[0]);
	$max = max($movieList);
	$top_winners = array_keys($movieList, $max);
	return [ 'top' => $top_winners, 'count' => $max ];
}


function countMySpins($id) {
	$sql = "SELECT count(*) AS `count` FROM `week` WHERE `spinner` = '$id'";
	$good = db($sql)[0]['count'];

	$sql = "SELECT `error_spin` FROM `week` WHERE `spinner` = '$id' AND `error_spin` != ''";
	$data = db($sql);

	$error_spins = [];
	if ($data) {
		foreach ($data as $errors) {
			$list = explode(",", $errors['error_spin']);

			if (count($list) > 1) {
				foreach ($list as $item) {
					$error_spins[] = str_replace(" ", "", $item);
				}
			}
			else {
				$error_spins[] = str_replace(" ", "", $list[0]);
			}
		}
	}

	$bad = count($error_spins);

	$total = $good + $bad;

	return [ 'good' => $good, 'bad' => $bad, 'total' => $total ];
}

function countMySpins_noChoice($id) {
	$sql = "SELECT count(*) AS `count` FROM `week` WHERE `spinner` = '$id' AND `selection_method` != 'viewer choice'";
	$good = db($sql)[0]['count'];

	$sql = "SELECT `error_spin` FROM `week` WHERE `spinner` = '$id' AND `error_spin` != '' AND `selection_method` != 'viewer choice'";
	$data = db($sql);

	$error_spins = [];
	if ($data) {
		foreach ($data as $errors) {
			$list = explode(",", $errors['error_spin']);

			if (count($list) > 1) {
				foreach ($list as $item) {
					$error_spins[] = str_replace(" ", "", $item);
				}
			}
			else {
				$error_spins[] = str_replace(" ", "", $list[0]);
			}
		}
	}

	$bad = count($error_spins);

	$total = $good + $bad;

	return [ 'good' => $good, 'bad' => $bad, 'total' => $total ];
}


function listOfSpunNumbersByViewer_noChoice($id) {
	$sql = "SELECT `winning_wedge`, `error_spin` FROM `week` WHERE `spinner` = $id AND `selection_method` != 'viewer choice'";
	$data = db($sql);

	$list = [];
	if ($data != NULL) {
		foreach ($data as $spin) {
			$list[] = $spin['winning_wedge'];
			if ($spin['error_spin'] != "") {
				$espin = explode(",", $spin['error_spin']);
				if (count($espin) > 1) {
					foreach ($espin as $ii) {
						$list[] = str_replace(" ", "", $ii) . "*";
					}
				}
				else {
					$list[] = str_replace(" ", "", $spin['error_spin']) . "*";
				}
			}
		}
	}
	return $list;
}


function getSpunViewers_v2($id) {
	$sql = "SELECT * FROM `week` WHERE `spinner` = $id AND `selection_method` != 'viewer choice' ORDER BY `winning_moviegoer`";
	$data = db($sql);

	$list = [];

	if ($data != NULL) {
		foreach ($data as $item) {
			$name = getViewerName($item['moviegoer_' . $item['winning_wedge']]);
			if (array_key_exists($name, $list)) {
				$list[$name]++;
			}
			else {
				$list[$name] = 1;
			}
			//$list[] = getViewerName($item['moviegoer_'.$item['winning_wedge']]);
			//$list[] = $item['selection_method'] [$item['winning_wedge'];
		}
	}

	return $list;
}

function get_current_streak($pdo) {
	$stmt = $pdo->prepare('SELECT winning_moviegoer FROM week ORDER BY `date` DESC');
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$last_winner = $result[0];
	$i = 0;

	while ($result[$i] == $last_winner) {
		$i++;
	}

	return [ "winner_id" => $last_winner, "count" => $i ];
}


function find_best_or_worst_watched_film_with_year_option($best_or_worst = "best", $year = NULL) {
	if ($best_or_worst == "best") {
		$order = "DESC";
	}
	else {
		$order = "ASC";
	}

	if ($year != NULL) {
		$time1 = $year . "-01-01";
		$time2 = $year . "-12-31";
		$sql = "SELECT * FROM ( SELECT week.id, winning_film, films.name, (COALESCE(tomatometer, 0)+COALESCE(rt_audience, 0)+COALESCE(imdb, 0)) / ( COUNT(tomatometer) + COUNT(rt_audience) + COUNT(imdb) ) AS avg_rating FROM week LEFT JOIN films ON (week.winning_film = films.id) WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE) GROUP BY id ORDER BY avg_rating $order ) AS `temp.php` WHERE `temp.php`.`avg_rating` IS NOT NULL";
	}
	else {
		$sql = "SELECT * FROM ( SELECT week.id, winning_film, films.name, (COALESCE(tomatometer, 0)+COALESCE(rt_audience, 0)+COALESCE(imdb, 0)) / ( COUNT(tomatometer) + COUNT(rt_audience) + COUNT(imdb) ) AS avg_rating FROM week LEFT JOIN films ON (week.winning_film = films.id) GROUP BY id ORDER BY avg_rating $order ) AS `temp.php` WHERE `temp.php`.`avg_rating` IS NOT NULL;";
	}
	//echo $sql;

	$result = db($sql);
	return $result;
}


function get_service_stats() {

	$sql = "SELECT `format`, COUNT(*) FROM `week` GROUP BY `format` ORDER BY COUNT(*) DESC";

	$result = db($sql);

	return $result;
}

function get_selector_stats() {

	$sql = "SELECT `selection_method`, COUNT(*) FROM `week` GROUP BY `selection_method` ORDER BY COUNT(*) DESC";

	$result = db($sql);

	return $result;
}


//returns array of everyone's longest streak.
function find_longest_streak_v2($pdo) {
	$stmt = $pdo->prepare('SELECT winning_moviegoer FROM week WHERE selection_method != ? ORDER BY `date`, id ASC');
	$stmt->execute([ 'viewer choice' ]);
	$list_of_winners = $stmt->fetchAll(PDO::FETCH_COLUMN);

	$max_wins = [];
	$last_winner = 0;
	$win_counter = 1;

	foreach ($list_of_winners as $one_winner) {
		//print_r($one_winner);
		if ($one_winner == $last_winner) {
			$win_counter++;
		}
		else {
			if (array_key_exists($last_winner, $max_wins)) {
				if ($max_wins[$last_winner] < $win_counter) {
					$max_wins[$last_winner] = $win_counter;
				}
			}
			else {
				$max_wins[$last_winner] = $win_counter;
			}
			$win_counter = 1;
		}
		$last_winner = $one_winner;
		//print_r($max_wins);
	}
	if (array_key_exists($last_winner, $max_wins)) {
		if ($max_wins[$last_winner] < $win_counter) {
			$max_wins[$last_winner] = $win_counter;
		}
	}
	else {
		$max_wins[$last_winner] = $win_counter;
	}
	//print_r($max_wins);
	return $max_wins;
}

function get_dry_spell_for_all_v2($pdo) {
	$stmt = $pdo->prepare('SELECT winning_moviegoer, attendees FROM week ORDER BY `date` ASC');
	$stmt->execute();
	$result = $stmt->fetchAll();

	$attend_counter = [];
	$attend_max = [];

	$viewer_list = get_list_of_viewers($pdo, 'id', 'ASC');
	foreach ($viewer_list as $viewer) {
		$attend_counter[$viewer['id']] = 0;
		$attend_max[$viewer['id']] = 0;
	}

	foreach ($result as $a_week) {
		$attendees = explode(", ", $a_week['attendees']);
		foreach ($viewer_list as $viewer) {
			//if viewer id is in $attendees, and they are not the winner, add one to their counter
			//if viewer id is in attendees, and they are the winner, check to see if this is a max, save it, and reset counter
			//if viewer id is not in attendees, do not add anything
			if (in_array($viewer['id'], $attendees) && $a_week['winning_moviegoer'] != $viewer['id']) {
				$attend_counter[$viewer['id']]++;
			}
			else if (in_array($viewer['id'], $attendees) && $a_week['winning_moviegoer'] == $viewer['id']) {
				if ($attend_counter[$viewer['id']] > $attend_max[$viewer['id']]) {
					$attend_max[$viewer['id']] = $attend_counter[$viewer['id']];
				}
				$attend_counter[$viewer['id']] = 0;
			}
		}
	}

	foreach ($viewer_list as $viewer) {
		if ($attend_counter[$viewer['id']] > $attend_max[$viewer['id']]) {
			$attend_max[$viewer['id']] = $attend_counter[$viewer['id']];
		}
	}

	return $attend_max;
}


function count_viewer_services($viewer_id) {
	$sql = "SELECT `format`, COUNT(*) FROM `week` WHERE `winning_moviegoer` = '$viewer_id' GROUP BY `format`";

	$return = db($sql);

	$values = [];

	if ($return != NULL) {
		foreach ($return as $item) {
			$values[$item['format']] = $item['COUNT(*)'];
		}
		arsort($values);
	}
	return $values;
}

function count_yearly_events($year) {
	$time1 = $year . "-01-01";
	$time2 = $year . "-12-31";
	$sql = "SELECT COUNT(*) FROM `week` WHERE `date` BETWEEN CAST('$time1' AS DATE) AND CAST('$time2' AS DATE)";

	$return = db($sql);


	return $return[0]['COUNT(*)'];
}


function viewer_watchtime($year = NULL) {
	if ($year == NULL) {
		$sql = "SELECT `runtime`, `attendees` FROM `week`";
	}

	$viewer_times = [];
	$result = db($sql);

	foreach ($result as $week) {
		$attendees = explode(",", $week['attendees']);
		foreach ($attendees as $viewer) {
			if (isset($viewer_times[trim($viewer)])) {
				$viewer_times[trim($viewer)] += $week['runtime'];
			}
			else {
				$viewer_times[trim($viewer)] = $week['runtime'];
			}

		}
	}

	return $viewer_times;
}

function list_winning_films_and_service_v2($pdo) {
	$stmt = $pdo->prepare('SELECT winning_film, format, `date` FROM week');
	$stmt->execute();
	$list = $stmt->fetchAll();
	return $list;
}

function count_viewer_win_streak_when_attending_and_not_viewer_choice($pdo, $viewer) {
	$stmt = $pdo->prepare('SELECT `date`, winning_moviegoer, attendees, selection_method FROM week WHERE selection_method != ? ORDER BY `date` ASC');
	$stmt->execute([ 'viewer choice' ]);
	$result = $stmt->fetchAll();

	$counter = 0;
	$max_counter = 0;
	$dates = [];
	$final_dates = [];

	foreach ($result as $a_week) {
		$attendees = explode(", ", $a_week['attendees']);
		if (in_array($viewer, $attendees)) {
			if ($viewer == $a_week['winning_moviegoer']) {
				$counter++;
				$dates[] = $a_week['date'];
			}
			else {
				if ($counter > $max_counter) {
					$max_counter = $counter;
					$final_dates = $dates;
				}
				$counter = 0;
				unset($dates);
			}
		}
	}

	if ($counter > $max_counter) {
		$max_counter = $counter;
		$final_dates = $dates;
	}

	return [ 'count' => $max_counter, 'dates' => $final_dates ];
}
