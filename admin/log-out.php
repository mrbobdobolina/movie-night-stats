<?php

require_once("../common.php");

include('inc/credentials.php');

setcookie('password', '', time() - 60 * 60 * 24 * 365);

header('Location: '.WEB_ROOT.'/admin/');
?>
