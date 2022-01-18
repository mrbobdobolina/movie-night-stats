<?php

require_once("../common.php");

$db = new \PDO('mysql:dbname='.DB_NAME.';host=localhost;charset=utf8mb4', DB_USER, DB_PASS);

$auth = new \Delight\Auth\Auth($db);

if(isset($_POST['email']) && isset($_POST['password'])){
	try {
			$auth->login($_POST['email'], $_POST['password']);
			    //echo 'User is logged in';
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
	    die('Wrong email address');
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
	    die('Wrong password');
	}
	catch (\Delight\Auth\EmailNotVerifiedException $e) {
	    die('Email not verified');
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    die('Too many requests');
	}
}



if ($auth->isLoggedIn()) {
    //echo 'User is signed in';
		$show = 1;
}
else {
    //echo 'User is not signed in yet';
		$show = 2;
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
		<link href="<?php echo WEB_ROOT; ?>/assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >

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

<?php if($show == 1): ?>
	<main>
	  <div class="album py-5 bg-light">
	    <div class="container">
				<p class="display-6 text-center mb-5">Welcome back, Keeper of Records.</p>
	      <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">
					<p>How may we be of service?</p>
					<ul>
						<li><a href="add-list.php">Random Assignments</a></li>
						<li><a href="add-viewer.php" >Add Viewer</a></li>
						<li><a href="add-movie.php" >Add Movie</a></li>
						<li><a href="add-game.php" >Add Game</a></li>
						<li><a href="add-spinner.php" >Add Spinner</a></li>
						<li><a href="log-out.php" >Log Out</a></li>
					</ul>
	      </div>
	    </div>
	  </div>
	</main>
<?php else: ?>
	<main>
	  <div class="album py-5 bg-light">
	    <div class="container">
				<p class="display-6 text-center mb-5">You should probably login or whatever.</p>
	      <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">
					<form action="index.php" method="post">
					  <div class="mb-3">
					    <label for="email" class="form-label">Email address</label>
					    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
					    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
					  </div>
					  <div class="mb-3">
					    <label for="password" class="form-label">Password</label>
					    <input type="password" name="password" class="form-control" id="password">
					  </div>
					  <button type="submit" class="btn btn-primary">Submit</button>
					</form>
	      </div>
	    </div>
	  </div>
	</main>
<?php endif; ?>

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
