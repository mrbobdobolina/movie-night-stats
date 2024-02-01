<?php

function is_logged_in() {
	return !empty($_COOKIE['password']);
}

function is_admin() {
	if (is_logged_in()) {
		return password_verify(ADMIN_PASSWORD, $_COOKIE['password']);
	}
	return FALSE;
}

function restrict_page_to_admin() {
	if (is_logged_in()) {
		if (is_admin()) {
			return TRUE;
		}
	}
	header('Location: ' . WEB_ROOT . '/admin/');
	die();
}

?>
