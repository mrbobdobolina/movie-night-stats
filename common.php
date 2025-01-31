<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('settings.config.php');
include('inc/db.php');
include('inc/function_showings.php');
include('inc/function_movies.php');
include('inc/function_spins.php');
include('inc/function_services.php');
include('inc/function_viewers.php');
include('inc/function_years.php');

function echo_version_number(){
  return "6.0 alpha";
}

function required_db_version(){
  return "4";
}

function read_db_version($pdo){
  $stmt = $pdo->prepare('SELECT value FROM options WHERE name = :name');
  $stmt->execute(['name' => 'db_version']);
  $result = $stmt->fetchColumn();
  return $result;
}
