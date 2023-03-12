<?php

include_once('common.php');

$db_counter = 0;

$url = ROOT.'/pages/404.php';

if(file_exists(ROOT.'/pages/'.$_GET['url'].'.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'.php';
}
elseif(file_exists(ROOT.'/pages/'.$_GET['url'].'/index.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'/index.php';
}

template('header');

include($url);


include(ROOT.'/template/footer.php');

