<?php

require_once('common.php');

$url = ROOT.'/pages/404.php';

if(file_exists(ROOT.'/pages/'.$_GET['url'].'.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'.php';
}
elseif(file_exists(ROOT.'/pages/'.$_GET['url'].'/index.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'/index.php';
}

template('header');

include($url);


template('footer'); 
