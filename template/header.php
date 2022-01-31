<?php
require_once("common.php");
add_page_load();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<title>Movie Night Stats</title>


	<!-- jQuery -->
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/jquery/v3.3.1/jquery.min.js"></script>

	<!-- Bootstrap -->
	<link href="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >
	<script src="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.0.0-beta2/js/bootstrap.bundle.min.js"></script>

	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/assets/datatables/v1.10.23/datatables.min.css"/>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/datatables/v1.10.23/datatables.min.js"></script>

	<!-- Fitty -->
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/fitty/fitty.min.js"></script>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/2b50968540.js" crossorigin="anonymous"></script>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

	<!-- Charts CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
	<script src="https://cdn.jsdelivr.net/combine/npm/chart.js@3.3.2,npm/chart.js@3.5.0"></script>

	<!-- Favicons -->
	<link rel="apple-touch-icon" href="images/favicon_32.png" sizes="180x180">
	<link rel="icon" href="images/favicon_32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="images/favicon_32.png" sizes="16x16" type="image/png">
	<link rel="icon" href="images/favicon_32.png">

	<!-- Movie Night Stats -->
	<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>/assets/movie-night-stats/main.css">
</head>
<body>
	<?php
	$now = new DateTime();
	if(($now >= new DateTime('December 21') || $now <= new DateTime('March 20')) && rand(1,100) < 70):
	?>
		<script src="assets/seasonal/snow/snowflakes.min.js"></script>
		<script>
			var sf = new Snowflakes();
		</script>

	<?php endif;?>

<?php template('nav'); ?>

<main>

	<?php
	$events = getListOfEvents("DESC");
	$count_events = count($events);
	$fireworks_random = rand(1,100);
	$lastWinner = get_last_winner();

	if($count_events % 100 == 0 || $count_events % 50 == 0 || $fireworks_random == 1 || $lastWinner == 8):
	?>
		<script src="<?php echo WEB_ROOT; ?>/assets/fireworks/v1.0.0/fireworks.js"></script>
		<script>
		const container = document.querySelector('.container')

		const fireworks = new Fireworks({
			target: container,
			hue: 120,
			startDelay: 1,
			minDelay: 20,
			maxDelay: 30,
			speed: 4,
			acceleration: 1.05,
			friction: 0.98,
			gravity: 1,
			particles: 75,
			trace: 3,
			explosion: 5,
			boundaries: {
				top: 50,
				bottom: container.clientHeight,
				left: 50,
				right: container.clientWidth
			},
			sound: {
				enable: false,
				list: [
					'explosion0.mp3',
					'explosion1.mp3',
					'explosion2.mp3'
				],
				min: 4,
				max: 8
			}
		})

		// start fireworks
		fireworks.start()
		</script>
	<?php endif; ?>
