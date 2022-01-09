<?php 
$starttime = microtime(true);
require_once("common.php"); ?>
<?php
add_page_load();
$numbers = $numberTypes[rand(0,3)];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Movie Night Stats</title>

    <!-- Bootstrap core CSS -->
<link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://kit.fontawesome.com/2b50968540.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 <script type="text/javascript" src="DataTables/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <!-- Favicons -->
<link rel="apple-touch-icon" href="images/favicon_32.png" sizes="180x180">
<link rel="icon" href="images/favicon_32.png" sizes="32x32" type="image/png">
<link rel="icon" href="images/favicon_32.png" sizes="16x16" type="image/png">
<link rel="icon" href="images/favicon_32.png">

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
			ul h5{
				font-weight:bold;
				margin-top: 20px;
			}
    </style>
<script src="https://cdn.jsdelivr.net/combine/npm/chart.js@3.3.2,npm/chart.js@3.5.0"></script>
    
  </head>
  <body>
		<?php		
		$now = new DateTime();
		if(($now >= new DateTime('December 21') || $now <= new DateTime('March 20')) && rand(1,100) < 75):
		?>	
			<script src="https://unpkg.com/magic-snowflakes/dist/snowflakes.min.js"></script>
			<script>
		    	var sf = new Snowflakes();
					</script>
			<?php endif;?>

<?php require_once("nav.php"); ?>

<main>
	
	<?php $events = getListOfEvents("DESC");
	$count_events = count($events);
	$fireworks_random = rand(1,100);
	$lastWinner = get_last_winner();
	
	if($count_events % 100 == 0 || $count_events % 50 == 0 || $fireworks_random == 1 || $lastWinner == 8):
	?>
	<script src="fireworks/fireworks.js"></script>
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