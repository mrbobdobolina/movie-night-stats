<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- jQuery -->
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/jquery/v3.7.0/jquery-3.7.0.min.js"></script>

<!-- Bootstrap -->
<link href="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.3.2/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.3.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<link
	rel="stylesheet"
	type="text/css"
	href="<?php echo WEB_ROOT; ?>/assets/datatables/v1.10.23/datatables.min.css" />
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/datatables/v1.10.23/datatables.min.js"></script>

<!-- Fitty -->
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/assets/fitty/fitty.min.js"></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/2b50968540.js" crossorigin="anonymous"></script>

<!-- Nanobar -->
<script src="/assets/nanobar/nanobar.min.js"></script>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

<!-- Charts CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
<script src="https://cdn.jsdelivr.net/combine/npm/chart.js@3.3.2,npm/chart.js@3.5.0"></script>

<!-- Favicons -->
<link rel="icon" href="images/favicon_32.png">

<!-- Movie Night Stats -->
<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>/assets/movie-night-stats/movie-night-stats.min.css">
<script src="<?php echo WEB_ROOT; ?>/assets/movie-night-stats/script.js"></script>


<?php $season = get_seasonal_weather();
if ($season == 'sakura'): ?>
	<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>/assets/seasonal/sakura/sakura.css">
	<script src="<?php echo WEB_ROOT; ?>/assets/seasonal/sakura/sakura.js"></script>
<?php endif; ?>

<?php if ($season == 'snow'): ?>
	<script src="<?php echo WEB_ROOT; ?>/assets/seasonal/snow/snowflakes.min.js"></script>
	<script>
		var sf = new Snowflakes();
	</script>
<?php endif; ?>
