<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if (!$auth->isLoggedIn()) {
	header(sprintf("Location: %s", "../"));
	  exit(); 
}


if(isset($_POST)){
	
	
	$date = $_POST['date']; 
	
	for($i=1; $i<=12; $i++){
		
		if(isset($_POST["wedge_$i"])){
			$movie_id = $_POST["wedge_$i"];
			${"wedge_$i"} = addslashes($_POST["wedge_$i"]); 
		} else {
			${"wedge_$i"} = 0;
		}
		
		if(isset($_POST["viewer_$i"])){
			${"viewer_$i"} = addslashes($_POST["viewer_$i"]); 
		} else {
			${"viewer_$i"} = 0;
		}
		
		//check films db, if first_instance is not set, set first instance to date
		
		$sql = "UPDATE `films` SET `first_instance` = '$date' WHERE `id` = $movie_id AND `first_instance` IS NULL";
		db($sql);
		
		//if date is greater than last_instance, change to this date
		$sql = "UPDATE `films` SET `last_instance` = '$date' WHERE `id` = $movie_id AND (`last_instance` IS NULL OR `last_instance` <= '$date'))";
		db($sql);
	}
	
	/*$wedge_1 = addslashes($_POST['wedge_1']);  
	$wedge_2 = addslashes($_POST['wedge_2']);  
	$wedge_3 = addslashes($_POST['wedge_3']);  
	$wedge_4 = addslashes($_POST['wedge_4']);  
	$wedge_5 = addslashes($_POST['wedge_5']);  
	$wedge_6 = addslashes($_POST['wedge_6']);  
	$wedge_7 = addslashes($_POST['wedge_7']);  
	$wedge_8 = addslashes($_POST['wedge_8']);  
	$wedge_9 = addslashes($_POST['wedge_9']);  
	$wedge_10 = addslashes($_POST['wedge_10']);  
	$wedge_11 = addslashes($_POST['wedge_11']);  
	$wedge_12 = addslashes($_POST['wedge_12']);  
	$viewer_1 = $_POST['viewer_1'];  
	$viewer_2 = $_POST['viewer_2'];  
	$viewer_3 = $_POST['viewer_3'];  
	$viewer_4 = $_POST['viewer_4'];  
	$viewer_5 = $_POST['viewer_5'];  
	$viewer_6 = $_POST['viewer_6'];  
	$viewer_7 = $_POST['viewer_7'];  
	$viewer_8 = $_POST['viewer_8'];  
	$viewer_9 = $_POST['viewer_9'];  
	$viewer_10 = $_POST['viewer_10'];  
	$viewer_11 = $_POST['viewer_11'];  
	$viewer_12 = $_POST['viewer_12'];  */
	$spinner = $_POST['spinner'];  
	$winning_wedge = $_POST['winning_wedge'];  
	$format = addslashes($_POST['format']);  
	
	if(isset($_POST['error_spin'])){
		$error_spin = $_POST['error_spin'];  
	} else {
		$error_spin = "";
	}
	
	if(isset($_POST['runtime'])){
		$runtime = $_POST['runtime'];
	} else {
		$runtime = 0;
	}
	
	$scribe = $_POST['scribe'];  
	$selection_method = $_POST['selection_method'];  
	$theme = addslashes($_POST['theme']);  
	$attendees = implode(', ', $_POST['attendees']);
	$attend_array = $_POST['attendees'];
	
	foreach($attend_array as $person){
		$sql_i = "UPDATE `viewers` SET `attendance` = `attendance` + 1 WHERE `id` = '$person'";
		
		db($sql_i);
	}
	
	$winning_film_var = 'wedge_'.$winning_wedge;
	$winning_film = $$winning_film_var;
	
	$winning_viewer = $_POST['viewer_'.$winning_wedge];
	
	$sql_ii = "UPDATE `spinners` SET `uses` = `uses` + 1 WHERE `name` = '$selection_method";
	db($sql_ii);
	
	
	$sql= "INSERT INTO `week` ( `id`, date, `wheel_1`, `wheel_2`, `wheel_3`, `wheel_4`, `wheel_5`, `wheel_6`, `wheel_7`, `wheel_8`, `wheel_9`, `wheel_10`, `wheel_11`, `wheel_12`, `moviegoer_1`, `moviegoer_2`, `moviegoer_3`, `moviegoer_4`, `moviegoer_5`, `moviegoer_6`, `moviegoer_7`, `moviegoer_8`, `moviegoer_9`, `moviegoer_10`, `moviegoer_11`, `moviegoer_12`, `spinner`, `winning_wedge`, `winning_film`, `format`, `error_spin`, `scribe`, `theme`, `attendees`, `selection_method`, `runtime`, `winning_moviegoer`) VALUES ( null, '$date', '$wedge_1', '$wedge_2', '$wedge_3', '$wedge_4', '$wedge_5', '$wedge_6', '$wedge_7', '$wedge_8', '$wedge_9', '$wedge_10', '$wedge_11', '$wedge_12', '$viewer_1', '$viewer_2', '$viewer_3', '$viewer_4', '$viewer_5', '$viewer_6', '$viewer_7', '$viewer_8', '$viewer_9', '$viewer_10', '$viewer_11', '$viewer_12', '$spinner', '$winning_wedge', '$winning_film', '$format', '$error_spin', '$scribe', '$theme', '$attendees', '$selection_method', '$runtime', '$winning_viewer')"; 
	
	//echo $sql;
	
	db($sql);
	
}


header(sprintf("Location: %s", "../"));
  exit(); 
?>