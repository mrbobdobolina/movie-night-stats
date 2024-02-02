<?php

function is_php_version_outdated(): bool {
	return PHP_VERSION_ID < 80000;
}

function is_service_url(): bool {
	return str_starts_with($_GET['url'], 'setup/');
}

function is_settings_file_okay(): bool {
	return file_exists(ROOT . '/settings.php');
}

function does_db_have_all_tables(): bool {
	$required_tables = [
		'dice', 'films', 'options', 'services', 'spinners', 'viewers', 'week'
	];

	$db_tables = db('SHOW TABLES');

	foreach($required_tables as $table){
		if(!in_array($table, $db_tables)){
			return FALSE;
		}
	}

	return TRUE;
}

function does_db_have_any_tables(): bool {
	return sizeof(db('SHOW TABLES'));
}
