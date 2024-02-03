<?php

include_once('common.php');

// Check the PHP installation
if(is_php_version_outdated()){
	echo 'Movie Night Stats requires PHP version 8.0.0 or above. Please upgrade your installation.';
	die();
}

// Check the health of the installation
if(is_settings_file_okay()){
	/** @noinspection PhpIncludeInspection */
	require ROOT.'/settings.php';

	include(ROOT.'/inc/db.php');

	//check DB Version
//	if(read_db_version_v2($pdo) != this_db_version()){
//		header('Location: ./init/error.php?e=oldDB');
//		die();
//	}

	add_page_load();
}
else if(!is_service_url()) {
	// No Settings file. Redirect to the setup page
	header('Location: ./setup/');
	die();
}

if(!does_db_have_any_tables() && !is_service_url()){
	header('Location: '.WEB_ROOT.'/setup/db');
	die();
}


$db_counter = 0;

$url = ROOT.'/pages/404.php';

if(file_exists(ROOT.'/pages/'.$_GET['url'].'.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'.php';
}
elseif(file_exists(ROOT.'/pages/'.$_GET['url'].'/index.php')){
	$url = ROOT.'/pages/'.$_GET['url'].'/index.php';
}

ob_start();

$url = str_replace('..', '.', $url);

include(ROOT.'/template/page.php');



echo ob_get_clean();
