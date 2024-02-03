<?php

/**
 * @var string $url
 */

include( ROOT . '/inc/Event_List.php' );

if (!defined('WEB_ROOT')) {
	define('WEB_ROOT', '');
}

?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Movie Night Stats</title>
	<?php include( ROOT . '/template/header.php' ); ?>
</head>
<body>

<?php include( ROOT . '/template/nav.php' ); ?>

<?php include( $url ); ?>

<?php include( ROOT . '/template/footer.php' ); ?>

</body>
</html>
