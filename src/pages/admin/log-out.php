<?php

$_SESSION['password'] = '';


//setcookie('password', '', time() - 60 * 60 * 24 * 365);

header('Location: ' . WEB_ROOT . '/');
