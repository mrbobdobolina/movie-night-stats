<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if (!$auth->isLoggedIn()) {
	header(sprintf("Location: %s", "../"));
	  exit(); 
}


if(isset($_POST)){
	
	
	$name = $_POST['name']; 
	$c1 = addslashes($_POST['color_1']);  
	$c2 = addslashes($_POST['color_2']);  
	$c3 = addslashes($_POST['color_3']);  
	$c4 = addslashes($_POST['color_4']);  
	$c5 = addslashes($_POST['color_5']);  
	$c6 = addslashes($_POST['color_6']);  
	$c7 = addslashes($_POST['color_7']);  
	$c8 = addslashes($_POST['color_8']);  
	$c9 = addslashes($_POST['color_9']);  
	$c10 = addslashes($_POST['color_10']);  
	$c11 = addslashes($_POST['color_11']);  
	$c12 = addslashes($_POST['color_12']);  
	
	$sql = "INSERT INTO `spinners` (`id`,`name`, `wedge_1`, `wedge_2`, `wedge_3`, `wedge_4`, `wedge_5`, `wedge_6`, `wedge_7`, `wedge_8`, `wedge_9`, `wedge_10`, `wedge_11`, `wedge_12`) VALUES (NULL, '$name', '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8', '$c9', '$c10', '$c11', '$c12')";
	
	
	db($sql);
	
}


header(sprintf("Location: %s", "add-spinner.php"));
  exit(); 
?>