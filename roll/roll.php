<?php

$db = FALSE;
function db($query = NULL){
	static $db;

	// Only connect to the database once.
	if(!isset($db)){
		$db = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
		if($db === FALSE){return $db->connect_error();}
	}

	// Execute a query if provided
	if(!empty($query)){
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
			return (sizeof($return)) ? $return : FALSE;
		}
		else {
			return $result;
		}
	}
	// If all else fails, return the database resource
	return $db;
}

 $url = 'http://roll.diceapi.com/json/d12';
 $dice = json_decode(file_get_contents($url), true);
 //print_r($dice);
 $path = "dice/".$dice['dice'][0]['value'].".jpg";
 $rolled_number = $dice['dice'][0]['value'];

 $sql = "INSERT INTO `dice` (`id`, `datetime`, `number`) VALUES (NULL, NOW(), $rolled_number)";
 $result = db($sql);

 if(!empty($_POST['number'])){
	 $number = $_POST['number'];
 }

 if(!empty($_POST['hue'])){
	 $hue = $_POST['hue'];
 } else {
	 $hue = 0;
 }
 ?>

<?php if($number == $dice['dice'][0]['value']):?>
	<?php $hue = $hue+90; ?>
  <img id="thedie" src="<?php echo $path; ?>" class="img-fluid" style="filter: hue-rotate(<?php echo $hue;?>deg)" alt="<?php echo $dice['dice'][0]['value'];	?>" data-number="<?php echo $dice['dice'][0]['value'];	?>" data-hue="<?php echo $hue;?>" data-passed="<?php echo $number; ?>" />
<?php else:?>
	<img id="thedie" src="<?php echo $path; ?>" class="img-fluid" alt="<?php echo $dice['dice'][0]['value'];	?>" data-number="<?php echo $dice['dice'][0]['value'];	?>" data-hue="0" data-passed="<?php echo $number; ?>" />
<?php endif;?>
