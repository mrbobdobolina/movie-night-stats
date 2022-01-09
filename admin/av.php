<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if (!$auth->isLoggedIn()) {
	header(sprintf("Location: %s", "../"));
	  exit(); 
}


if(isset($_POST['name']) && isset($_POST['color'])){
	$name = $_POST['name'];
	$color = $_POST['color'];
	$sql = "INSERT INTO `viewers` (`name`, `color`) VALUES ('$name', '$color')";
	echo $sql;
	db($sql);

}

header(sprintf("Location: %s", "add-viewer.php"));
  //exit(); 
?>