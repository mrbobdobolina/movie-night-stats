<?php require_once("../common.php"); ?>
<?php

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if (!$auth->isLoggedIn()) {
	header(sprintf("Location: %s", "../"));
	  exit();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Movie Night Stats</title>



		<!-- Bootstrap -->
		<link href="<?php echo WEB_ROOT; ?>assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >

    <!-- Favicons -->
<link rel="apple-touch-icon" href="../images/favicon_32.png" sizes="180x180">
<link rel="icon" href="../images/favicon_32.png" sizes="32x32" type="image/png">
<link rel="icon" href="../images/favicon_32.png" sizes="16x16" type="image/png">
<link rel="icon" href="../images/favicon_32.png">


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


<?php

$movies = getMovieList();

$movieSelect = "<option disabled selected></option>";

foreach($movies as $aFilm){
	$movieSelect .= "<option value=\"" . $aFilm["id"] . "\">" . $aFilm["name"] . "</option>";
}

$viewers = getListOfViewers();

$viewerSelect = "<option disabled selected></option>";

foreach($viewers as $aPerson){
	$viewerSelect .= "<option value=\"" . $aPerson["id"] . "\">" . $aPerson["name"] . "</option>";
}


$selectors = getSelectionTypes();

$selectorsSelect = "<option disabled selected></option>";

foreach($selectors as $aTool){
	$selectorsSelect .= "<option value=\"" . $aTool . "\">" . $aTool . "</option>";
}

?>

  </head>
  <body>

<header>

  <div class="navbar navbar-dark bg-red shadow-sm">

			<div class="container d-flex justify-content-between">
				<a href="add-list.php" class="nav-link text-white fw-bold">Random Assignments</a>
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
				<h2>Add a Game</h2>

				<form class="form" action="ag.php" method="post">

				<div class="form-group row">
					<label for="date" class="col-sm-1 col-form-label">Date:</label>
					<div class="col-sm-3">
						<input class="form-control" type="date" name="date" id="date" placeholder="yyyy-mm-dd" value="<?php echo date("Y-m-d"); ?>">
					</div>
				</div>
				<div class="col-8">
				<table class="table">
					<thead>
						<tr>
							<th>Wedge #</th>
							<th>Movie</th>
							<th>Viewer</th>
						</tr>
					</thead>
					<tbody>
						<?php for($i = 1; $i <= 12; $i++):?>
							<tr>
								<td><?php echo $i;?></td>
								<td>
									<select class="form-select" name="wedge_<?php echo $i;?>" id="wedge_<?php echo $i;?>">
										<?php echo $movieSelect; ?>
									</select>
								</td>
								<td>
									<select class="form-select" name="viewer_<?php echo $i;?>" id="viewer_<?php echo $i;?>">
										<?php echo $viewerSelect; ?>
									</select>
								</td>
							</tr>
						<?php endfor;?>
					</tbody>
				</table>
			</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Spinner: </label>
					<select class="form-select" name="spinner" id="spinner">
					  <?php echo $viewerSelect; ?>
					</select>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="winning_wedge">Winning Number: </label>
					<select class="form-select" name="winning_wedge" id="winning_wedge">
						<?php
						for($i = 1; $i < 13; $i++){
							echo "<option value='".$i."'>".$i."</option>";
						}?>
					</select>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Format: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="format" id="format">
					</div>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Error Spin(s): </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="errors" id="errors">
					</div>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Selection Method: </label>
					<select class="form-select" name="selection_method" id="selection_method">
					  <?php echo $selectorsSelect; ?>
					</select>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Scribe: </label>
					<select class="form-select" name="scribe" id="scribe">
					  <?php echo $viewerSelect; ?>
					</select>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Theme: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="theme" id="theme">
					</div>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Runtime: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="runtime" id="runtime">
					</div>
				</div>

			 <div class="form-group row  mt-3">
			    <label class="col-2">Attendees: </label>
			    <div class="col-8">
								<?php
								foreach($viewers as $key => $value):?>
							 <div class="custom-control custom-checkbox custom-control-inline">
							        <input name="attendees[]" id="attendees_<?php echo $value['id']; ?>" type="checkbox" class="custom-control-input" value="<?php echo $value['id']; ?>">
							        <label for="attendees_<?php echo $value['id']; ?>" class="custom-control-label"><?php echo $value['name']; ?></label>
							      </div>
							<?php endforeach;?>
						</div>
						</div>


				<input class="btn btn-primary" type="submit" value="Submit">


			</form>
	    </div>
	  </div>
	</main>


<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
   </div>
</footer>


    <script src="../bootstrap5/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


  </body>
</html>
