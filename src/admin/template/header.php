<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<title>Movie Night Stats</title>

	<!-- jQuery -->
	<script src="<?php echo WEB_ROOT; ?>/assets/jquery/v3.3.1/jquery.min.js"></script>

	<!-- Bootstrap -->
	<link href="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.2.0/css/bootstrap.min.css" rel="stylesheet">
	<script src="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.2.0/js/bootstrap.bundle.min.js"></script>

	<!-- Bootstrap Select -->
	<link
		href="<?php echo WEB_ROOT; ?>/assets/bootstrap-select/v1.14.0-beta2/css/bootstrap-select.min.css"
		rel="stylesheet">
	<script src="<?php echo WEB_ROOT; ?>/assets/bootstrap-select/v1.14.0-beta2/js/bootstrap-select.min.js"></script>

	<style>
		.btn-light, .btn-light:hover {
			color:            #212529;
			background-color: #fff;
			border:           1px solid #ced4da;
		}


		.btn-light:focus, .btn-light.focus {
			background-color: #fff;
			box-shadow:       0 0 0 .25rem rgba(13, 110, 253, .25);
		}

		.btn-light.disabled, .btn-light:disabled {
			background-color: #e9ecef;
		}

		.btn-light:not(:disabled):not(.disabled):active,
		.btn-light:not(:disabled):not(.disabled).active,
		.show > .btn-light.dropdown-toggle {
			background-color: #fff;
			box-shadow:       0 0 0 .25rem rgba(13, 110, 253, .25);
		}

		.btn-light:not(:disabled):not(.disabled):active:focus,
		.btn-light:not(:disabled):not(.disabled).active:focus,
		.show > .btn-light.dropdown-toggle:focus {
			background-color: #fff;
			box-shadow:       0 0 0 .25rem rgba(13, 110, 253, .25);
		}

	</style>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

	<!-- Favicons -->
	<link rel="apple-touch-icon" href="../images/favicon_32.png" sizes="180x180">
	<link rel="icon" href="../images/favicon_32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="../images/favicon_32.png" sizes="16x16" type="image/png">
	<link rel="icon" href="../images/favicon_32.png">

	<!-- Movie Night Stats -->
	<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>/assets/movie-night-stats/main.css">


	<style>
		.bd-placeholder-img {
			font-size:           1.125rem;
			text-anchor:         middle;
			-webkit-user-select: none;
			-moz-user-select:    none;
			user-select:         none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		.bg-red {
			background-color: #EA2F1C;
		}

		.navbar {
			text-weight: bold;
			text-shadow: 0px 2px black;
		}

		a {
			text-decoration: none;
		}

		.movie-title {
			width:         60%;
			white-space:   nowrap;
			overflow:      hidden;
			text-overflow: ellipsis;
		}

		.viewer-name {
			width: 30%;
		}

		.number {
			width: 10%;
		}

		.bold {
			font-weight: bold;
		}

		.header-image {
			max-width: 800px;
			display:   inline-block;
		}

		table thead {white-space: nowrap;}
	</style>


</head>
<body>

<header>
	<?php

	include( 'navigation.php' );

	?>
</header>

<main>
	<div class="album py-5 bg-light">
		<div class="container">
