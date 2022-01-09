<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if (!$auth->isLoggedIn()) {
	header(sprintf("Location: %s", "../"));
	  exit(); 
}


if(isset($_POST['name'])){
	$name = db_esc($_POST['name']);
	$year = $_POST['year'];
	$runtime = $_POST['runtime'];
	if($_POST['imdb']){
		$imdb = $_POST['imdb'];
	} else {
		$imdb = '';
	}
	
	if($_POST['rt_rating']){
		$rt = $_POST['rt_rating'];
	} else {
		$rt = '';
	}
	
	if($_POST['rta_rating']){
		$rta = $_POST['rta_rating'];
	} else {
		$rta = '';
	}
	
	if($_POST['mpaa']){
		$mpaa = $_POST['mpaa'];
	} else {
		$mpaa = '';
	}
	
	$sql = "SELECT * FROM `films` WHERE `name` = '$name'";
	
	$result = db($sql);
	
	if($result == NULL){
		$sql = "INSERT INTO `films` (`name`, `year`, `runtime`, `imdb`, `tomatometer`, `rt_audience`, `MPAA`) VALUES ('$name', '$year', '$runtime', NULLIF('$imdb',''), NULLIF('$rt',''), NULLIF('$rta',''), NULLIF('$mpaa','') )";
		//echo $sql;
		db($sql);
	}

}

header('Location: add-movie.php');
  exit(); 
?>