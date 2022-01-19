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
	<link href="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >
	<script src="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.0.0-beta2/js/bootstrap.bundle.min.js"></script>

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
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
		.bg-red{
			background-color:#EA2F1C;
		}
		.navbar{
			text-weight:bold;
			text-shadow: 0px 2px black;
		}
		a {
			text-decoration: none;
		}
		.movie-title{
			width:60%;
		  white-space: nowrap;
		  overflow: hidden;
		  text-overflow: ellipsis;
		}
		.viewer-name{
			width:30%;
		}
		.number{
			width:10%;
		}
		.bold{
			font-weight: bold;
		}
		.header-image{
			max-width:800px;
			display:inline-block;
		}

		table { width:250px;table-layout:fixed; }
		table tr { height:1em;  }
		td { overflow:hidden;white-space:nowrap;  }
  </style>


</head>
<body>

	<header>
	  <div class="navbar navbar-dark bg-red shadow-sm">
			<div class="container d-flex justify-content-between">
				<a href="add-list.php" class="nav-link text-white fw-bold">Scribe's List</a>
				<a href="add-viewer.php" class="nav-link text-white fw-bold">Add Viewer</a>
				<a href="add-movie.php" class="nav-link text-white fw-bold">Add Movie</a>
				<a href="add-game.php" class="nav-link text-white fw-bold">Add Game</a>
				<a href="add-spinner.php" class="nav-link text-white fw-bold">Add Spinner</a>
				<a href="log-out.php" class="nav-link text-white fw-bold">Log Out</a>
	    </div>
	  </div>
	</header>

	<main>
		<div class="album py-5 bg-light">
			<div class="container">
