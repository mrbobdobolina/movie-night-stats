<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Movie Night Stats Digital Dice</title>

    <!-- Bootstrap core CSS -->
<link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://kit.fontawesome.com/2b50968540.js" crossorigin="anonymous"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- Favicons -->
<link rel="apple-touch-icon" href="../images/favicon_32.png" sizes="180x180">
<link rel="icon" href="../images/favicon_32.png" sizes="32x32" type="image/png">
<link rel="icon" href="../images/favicon_32.png" sizes="16x16" type="image/png">
<link rel="icon" href="../images/favicon_32.png">

    <style>
			body{
				font-family: 'Open Sans', sans-serif;
			}
			.highlight{
				background-color: #ffef99;
			}
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
			.shadow-sm{
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
			
			table.homepage{ table-layout:fixed; }
			table tr.homepage{ height:1em;  }
			td.homepage{ overflow:hidden;white-space:nowrap;  } 
			
			canvas { 
				position: absolute;
			}
			
			.mpaa{
				font-variant-numeric: tabular-nums;
			}
			
			li{
				margin-bottom:10px;
				margin-top:10px;
			}
			ul{
				list-style-type: none;
				padding: 0;
				margin: 5;
			}
			.data{
				color: #fff;
				font-weight:bold;
			}
			
			.data_padding{
				padding-right:10px;
			}
			
			div#preload { display: none;}
    </style>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
  </head>
  <body>
<header>
  <div class="bg-red shadow-sm ">
			<div class="container d-flex header-image text-center" style="height:233px;">
				<a href="../"><img src="../images/MovieNightStats_v02B_Rectangle_Transparent.png" class="img-fluid"></a>
			</div>
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


    <script src="bootstrap5/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
		


      
  </body>
</html>
