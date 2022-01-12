<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <title>Movie Night Stats</title>

  <!-- Bootstrap core CSS -->
	<link href="../assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

	<!-- Favicons -->
	<link rel="apple-touch-icon" href="images/favicon_32.png" sizes="180x180">
	<link rel="icon" href="images/favicon_32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="images/favicon_32.png" sizes="16x16" type="image/png">
	<link rel="icon" href="images/favicon_32.png">

  <style>
		body{
			font-family: 'Open Sans', sans-serif;
		}
		.bg-red{
			background-color:#EA2F1C;
		}
		.header-image{
			max-width:800px;
			display:inline-block;
		}
  </style>

</head>
<?php

switch($_GET['e']){
	case 'settings.cfg':
		$text1 = 'Error: Settings.config does not exist!';

		$text2 = 'Please make a copy of settings-TEMPLATE.config ';
		$text2 .= 'then click <a href="../">here</a> to continue.';
		break;


	// https://mariadb.com/kb/en/mariadb-error-codes/
	case 'mysql-1045': // ER_ACCESS_DENIED_ERROR
		$text1 = 'DB Error: Access denied';

		$text2 = 'Check your login information in settings.config ';
		$text2 .= 'then click <a href="../">here</a> to continue.';
		break;

	case 'mysql-2002':
		$text1 = 'DB Error: Can\'t connect to server';

		$text2 = 'Check the database address in settings.config and make sure the MySQL server is running ';
		$text2 .= 'then click <a href="../">here</a> to continue.';
		break;


	default:
		$text1 = 'Error displaying the error';
		$text2 = 'The Error responible has been sacked.';
}


?>
<body>

	<header>
	  <div class="bg-red shadow-sm ">
			<a href="index.php">
				<div class="container d-flex header-image text-center" style="height:233px;">
					<img src="../images/MovieNightStats_v02B_Rectangle_Transparent.png" class="img-fluid">
				</div>
			</a>
		</div>
	</header>

	<main>
	  <div class="album py-5 bg-light">
	    <div class="container">
				<p class="display-6 text-center"><?php echo $text1; ?></p>
				<p class="text-center mb-5"><?php echo $text2; ?></p>
	    </div>
	  </div>
	</main>

</body>
</html>
