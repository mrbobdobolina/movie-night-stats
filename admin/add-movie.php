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
				<p class="display-6 text-center mb-5">Add a movie.</p>
	      <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">

					<div class="card-body">
						<p>Kinda feels like you already have enough of those...</p>
					</div>
					<div class="card-body">
						<form action="am.php" method="post">
						  <div class="form-group row mb-1">
						    <label for="name" class="col-4 col-form-label">Movie Name</label>
						    <div class="col-8">
						      <input id="name" name="name" type="text" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-1">
						    <label for="year" class="col-4 col-form-label">Movie Year</label>
						    <div class="col-8">
						      <input id="year" name="year" type="number" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-2">
						    <label for="runtime" class="col-4 col-form-label">Movie Runtime</label>
						    <div class="col-8">
						      <input id="runtime" name="runtime" type="number" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-1">
						    <label for="imdb" class="col-4 col-form-label">IMDB Rating</label>
						    <div class="col-8">
						      <input id="imdb" name="imdb" type="number" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-1">
						    <label for="rt_rating" class="col-4 col-form-label">RT Rating</label>
						    <div class="col-8">
						      <input id="rt_rating" name="rt_rating" type="number" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-1">
						    <label for="rta_rating" class="col-4 col-form-label">RT Audience Rating</label>
						    <div class="col-8">
						      <input id="rta_rating" name="rta_rating" type="number" class="form-control">
						    </div>
						  </div>
						  <div class="form-group row mb-1">
						    <label for="mpaa" class="col-4 col-form-label">MPAA</label>
						    <div class="col-8">
						      <input id="mpaa" name="mpaa" type="number" class="form-control">
						    </div>
						  </div>

						  <div class="form-group row">
						    <div class="offset-4 col-8">
						      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
						    </div>
						  </div>
						</form>
					</div>
					<div class="card-body">
						<?php $viewers = getMovieList();?>
											<ul>
											<?php foreach($viewers as $person):?>
												<li><?php echo $person['name'];?> <em>(<?php echo $person['id'];?>)</em></li>
											<?php endforeach;?>
										</ul>
					</div>

					</div>

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
