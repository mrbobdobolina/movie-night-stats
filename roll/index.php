<?php
require_once("../common.php");
add_page_load();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<title>Movie Night Stats - Digital D12</title>


	<!-- jQuery -->
	<script type="text/javascript" src="../assets/jquery/v3.3.1/jquery.min.js"></script>

	<!-- Bootstrap -->
	<link href="../assets/bootstrap/v5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet" >
	<script src="../assets/bootstrap/v5.0.0-beta2/js/bootstrap.bundle.min.js"></script>

	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="../assets/datatables/v1.10.23/datatables.min.css"/>
	<script type="text/javascript" src="../assets/datatables/v1.10.23/datatables.min.js"></script>

	<!-- Fitty -->
	<script type="text/javascript" src="../assets/fitty/fitty.min.js"></script>

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
	<link rel="apple-touch-icon" href="../images/favicon_32.png" sizes="180x180">
	<link rel="icon" href="../images/favicon_32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="../images/favicon_32.png" sizes="16x16" type="image/png">
	<link rel="icon" href="../images/favicon_32.png">

	<!-- Movie Night Stats -->
	<link rel="stylesheet" href="../assets/movie-night-stats/main.css">

</head>
<body>

  <header>
  	<div class="bg-red shadow-sm ">
  		<div class="container d-flex header-image text-center" style="height:233px;">
  			<a href="index.php">
  				<img src="../images/MovieNightStats_v02B_Rectangle_Transparent.png" class="img-fluid">
  			</a>
  		</div>
  	</div>
  </header>

<main>

  <div class="album py-5 bg-light">
    <div class="container">
						<p class="display-6 text-center">Digital d12.</p>

      <div class="row row-cols-1 flex d-flex justify-content-center">
				<div class="col-sm-12 col-md-6 col-lg-4 ">
							<div class="card">
								<div id="dice-roll">
							  <img id="thedie" src="dice/0.jpg" class="img-fluid" alt="?" data-number="0" data-hue="0" />
							</div>
							  <div class="card-body">
									<div class="d-grid gap-2 col-6 mx-auto">
							    <button id="roll-button" type="button" class="btn btn-primary">Roll Dice</button>
								</div>
							  </div>
							</div>
				</div>

      </div>
    </div>
  </div>
	<div id="preload">
		<img src="dice/1.jpg" /><img src="dice/2.jpg" /><img src="dice/3.jpg" /><img src="dice/4.jpg" /><img src="dice/5.jpg" /><img src="dice/6.jpg" /><img src="dice/7.jpg" /><img src="dice/8.jpg" /><img src="dice/9.jpg" /><img src="dice/10.jpg" /><img src="dice/11.jpg" /><img src="dice/12.jpg" />
	</div>

</main>

<script>
	$("#roll-button").click(function(){
		$("#roll-button").prop("disabled", true);
	  $.ajax({
			url: "roll.php",
			type:"POST",
			data: {number: $("#thedie").attr('data-number'), hue: $("#thedie").attr('data-hue') },
			success: function(result){
	    $("#dice-roll").html(result);
	  }});
		$("#roll-button").prop("disabled", false);
	});

	</script>

<footer class="text-muted py-5">
	<p class="text-center">(Powered by <a href="http://roll.diceapi.com">DiceAPI</a>)</p>
</footer>


  </body>
</html>
