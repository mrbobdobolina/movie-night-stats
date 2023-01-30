<?php

$db_counter = 0;

// PDO instantiation
try {
     $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// OLD mysqli instantiation
$db = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
function db($query = NULL){
	static $db;
	
	global $db_counter;

	// Only connect to the database once.
	if(!isset($db)){
		$db = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
		if($db->connect_errno){return ['db_error'=>$db->connect_errno];}
	}

	// Execute a query if provided
	if(!empty($query)){
		$db_counter++;
		$result = $db->query($query);
		// Stop if the DB errors
		if(!$result){
			return FALSE;
			// return $result->error;
		}
		// Format returned rows into an array
		elseif(stripos($query, 'SELECT ') !== FALSE) {
			$return = Array();
			while($row = $result->fetch_assoc()){
				$return[] = $row;
			}
			return (sizeof($return)) ? $return : [];
		}
		else {
			return $result;
		}
	}
	// If all else fails, return the database resource
	return $db;
}

function db_esc($text){
  return db()->real_escape_string($text);
}

// Check if DB successfully connects
if($db->connect_errno){
	header('Location: '.WEB_ROOT.'/init/error.php?e=mysql-'.$db->connect_errno);
	die();
}


function add_page_load(){

	if(AT_DB_ENABLED){
		// Only connect to the database once.
		if(!isset($db)){
			$db = new mysqli(AT_DB_ADDR, AT_DB_USER, AT_DB_PASS, AT_DB_NAME);
			if($db === FALSE){return $db->connect_error();}
		}

		$today = new DateTime(date("Y-m-d"));
		$stringDate = $today->format("Y-m-d");

		$query = "INSERT INTO `movie` (`date`, `count`) VALUES ('$stringDate', 1) ON DUPLICATE KEY UPDATE count=count+1";

		// Execute a query if provided
		if(!empty($query)){
			$result = $db->query($query);
			// Stop if the DB errors
			if(!$result){
				return FALSE;
				// return $result->error;
			}
			// Format returned rows into an array
			elseif(stripos($query, 'SELECT') !== FALSE) {
				$return = Array();
				while($row = $result->fetch_assoc()){
					$return[] = $row;
				}
				return (sizeof($return)) ? $return : FALSE;
			}
			else {
				return $result;
			}
		}
		// If all else fails, return the database resource
		return $db;
	}
	return FALSE;
}
