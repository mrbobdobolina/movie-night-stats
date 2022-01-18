<?php

function is_logged_in(){
	return TRUE;
}

function is_admin(){
	return TRUE;
}

function restrict_page_to_admin(){
	if(is_logged_in()){
		if(is_admin()){
			return TRUE;
		}
	}
	header('Location: '.WEB_ROOT.'/admin/');
	die();
}

?>
