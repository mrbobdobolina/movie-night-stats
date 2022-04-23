<?php

require_once("../common.php");


 $url = 'http://roll.diceapi.com/json/d12';
 $dice = json_decode(file_get_contents($url), true);
 //print_r($dice);
 $path = "dice/".$dice['dice'][0]['value'].".jpg";
 $rolled_number = $dice['dice'][0]['value'];

 $sql = "INSERT INTO `dice` (`id`, `datetime`, `number`) VALUES (NULL, NOW(), $rolled_number)";
 $result = db($sql);

 if(!empty($_POST['number'])){
	 $number = $_POST['number'];
 } else {
   $number = 0;
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
