<?php

function get_year_data($pdo){
  $stmt = $pdo->prepare('SELECT
        YEAR(date) AS year,
        COUNT(*) AS event_count,
        SUM(runtime) AS total_runtime
    FROM showings
    GROUP BY year
    ORDER BY year;');
	$stmt->execute();
	$result = $stmt->fetchAll();
	return $result;
}

function get_day_of_week_summary($pdo){
  $stmt = $pdo->prepare('SELECT DAYNAME(date) AS weekday, COUNT(*) AS event_count
    FROM showings
    GROUP BY weekday
    ORDER BY FIELD(weekday, ?, ?, ?, ?, ?, ?, ?);
    ');
	$stmt->execute(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
	$result = $stmt->fetchAll();
  $return = [];
  foreach($result as $day){
    $return[$day['weekday']] = $day['event_count'];
  }
	return $return;
}

function get_yearly_attend($pdo){
  $stmt = $pdo->prepare('SELECT YEAR(event_date) AS year, COUNT(*) AS cast_count
    FROM attendance
    GROUP BY year
    ORDER BY year;');
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	return $result;
}

function get_yearly_format($pdo){
  $stmt = $pdo->prepare('SELECT
        YEAR(date) AS year,
        format,
        SUM(runtime) AS total_runtime
    FROM showings
    GROUP BY year, format
    ORDER BY year, format;');
	$stmt->execute();
	$result = $stmt->fetchAll();
  $return = [];

  foreach($result as $row){
    $return[$row['year']][] = [$row['format'], $row['total_runtime']];
  }

	return $return;
}

function get_yearly_category_counts($pdo, $category){
    $sql = "
        SELECT YEAR(date) AS year, $category, COUNT(*) AS count
        FROM showings
        GROUP BY year, $category
        ORDER BY year, count DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
    $yearlyData = [];

foreach ($result as $row) {
    $year = $row['year'];
    $winner = $row[$category];
    $count = $row['count'];

    if (!isset($yearlyData[$year])) {
        $yearlyData[$year] = [];
    }

    $yearlyData[$year][$winner] = $count;
}
    return $yearlyData;
}

function get_movie_data_for_years($pdo, $year){
  $stmt = $pdo->prepare('SELECT * FROM showings WHERE YEAR(date) = ?');
	$stmt->execute([$year]);
	$result = $stmt->fetchAll();

  $films_and_rankings = [];
  foreach($result as $row){
    $films_and_rankings[] = get_film_array($pdo, $row);
  }
  $films = [];
  foreach($films_and_rankings as $list){
    foreach($list as $item){
      $films[] = $item;
    }
  }

	return $films;
}

function count_showings($pdo, $year){
  $stmt = $pdo->prepare('SELECT number, COUNT(*) as occurrences
      FROM (
          SELECT wheel_1 AS number FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_2 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_3 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_4 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_5 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_6 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_7 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_8 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_9 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_10 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_11 FROM showings WHERE YEAR(date) = ?
          UNION ALL
          SELECT wheel_12 FROM showings WHERE YEAR(date) = ?
      ) AS all_numbers
      WHERE number IS NOT NULL
      GROUP BY number
      ORDER BY occurrences DESC;
      ');
	$stmt->execute([$year,$year,$year,$year,$year,$year,$year,$year,$year,$year,$year,$year]);
	$result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

  unset($result[0]);

	return $result;
}

function yearly_minutes_watched($pdo, $year){
  $stmt = $pdo->prepare('SELECT format, SUM(runtime) AS total_runtime
      FROM showings
      WHERE YEAR(date) = ?
      GROUP BY format
      ORDER BY total_runtime DESC;
      ');
	$stmt->execute([$year]);
	$result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	return $result;
}
