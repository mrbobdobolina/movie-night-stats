<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

try {
    $auth->logOut();
}
catch (\Delight\Auth\NotLoggedInException $e) {
    die('Not logged in');
}

header(sprintf("Location: %s", "../"));
  exit(); 
?>