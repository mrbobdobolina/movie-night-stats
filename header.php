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
			
			.timeline {
			    border-left: 3px solid #727cf5;
			    border-bottom-right-radius: 4px;
			    border-top-right-radius: 4px;
			    background: rgba(114, 124, 245, 0.09);
			    margin: 0 auto;
			    letter-spacing: 0.2px;
			    position: relative;
			    line-height: 1.4em;
			    font-size: 1.03em;
			    padding: 50px;
			    list-style: none;
			    text-align: left;
			    max-width: 40%;
			}

			@media (max-width: 767px) {
			    .timeline {
			        max-width: 98%;
			        padding: 25px;
			    }
			}

			.timeline h1 {
			    font-weight: 300;
			    font-size: 1.4em;
			}

			.timeline h2,
			.timeline h3 {
			    font-weight: 600;
			    font-size: 1rem;
			    margin-bottom: 10px;
			}

			.timeline .event {
			    border-bottom: 1px dashed #e8ebf1;
			    padding-bottom: 25px;
			    margin-bottom: 25px;
			    position: relative;
			}

			@media (max-width: 767px) {
			    .timeline .event {
			        padding-top: 30px;
			    }
			}

			.timeline .event:last-of-type {
			    padding-bottom: 0;
			    margin-bottom: 0;
			    border: none;
			}

			.timeline .event:before,
			.timeline .event:after {
			    position: absolute;
			    display: block;
			    top: 0;
			}

			.timeline .event:before {
			    left: -207px;
			    content: attr(data-date);
			    text-align: right;
			    font-weight: 100;
			    font-size: 0.9em;
			    min-width: 120px;
			}

			@media (max-width: 767px) {
			    .timeline .event:before {
			        left: 0px;
			        text-align: left;
			    }
			}

			.timeline .event:after {
			    -webkit-box-shadow: 0 0 0 3px #727cf5;
			    box-shadow: 0 0 0 3px #727cf5;
			    left: -55.8px;
			    background: #fff;
			    border-radius: 50%;
			    height: 9px;
			    width: 9px;
			    content: "";
			    top: 5px;
			}

			@media (max-width: 767px) {
			    .timeline .event:after {
			        left: -31.8px;
			    }
			}

			.rtl .timeline {
			    border-left: 0;
			    text-align: right;
			    border-bottom-right-radius: 0;
			    border-top-right-radius: 0;
			    border-bottom-left-radius: 4px;
			    border-top-left-radius: 4px;
			    border-right: 3px solid #727cf5;
			}

			.rtl .timeline .event::before {
			    left: 0;
			    right: -170px;
			}

			.rtl .timeline .event::after {
			    left: 0;
			    right: -55.8px;
			}
			
			.mt-70 {
			    margin-top: 70px
			}

			.mb-70 {
			    margin-bottom: 70px
			}

			.card {
			    box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
			    border-width: 0;
			    transition: all .2s
			}

			.card {
			    position: relative;
			    display: flex;
			    flex-direction: column;
			    min-width: 0;
			    word-wrap: break-word;
			    background-color: #fff;
			    background-clip: border-box;
			    border: 1px solid rgba(26, 54, 126, 0.125);
			    border-radius: .25rem
			}

			.card-body {
			    flex: 1 1 auto;
			    padding: 1.25rem
			}

			.vertical-timeline {
			    width: 100%;
			    position: relative;
			    padding: 1.5rem 0 1rem
			}

			.vertical-timeline::before {
			    content: '';
			    position: absolute;
			    top: 0;
			    left: 67px;
			    height: 100%;
			    width: 4px;
			    background: #e9ecef;
			    border-radius: .25rem
			}

			.vertical-timeline-element {
			    position: relative;
			    margin: 0 0 1rem
			}

			.vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
			    visibility: visible;
			    animation: cd-bounce-1 .8s
			}

			.vertical-timeline-element-icon {
			    position: absolute;
			    top: 0;
			    left: 60px
			}

			.vertical-timeline-element-icon .badge-dot-xl {
			    box-shadow: 0 0 0 5px #fff
			}

			.badge-dot-xl {
			    width: 18px;
			    height: 18px;
			    position: relative
			}

			.badge:empty {
			    display: none
			}

			.badge-dot-xl::before {
			    content: '';
			    width: 10px;
			    height: 10px;
			    border-radius: .25rem;
			    position: absolute;
			    left: 50%;
			    top: 50%;
			    margin: -5px 0 0 -5px;
			    background: #fff
			}

			.vertical-timeline-element-content {
			    position: relative;
			    margin-left: 90px;
			    font-size: .8rem
			}

			.vertical-timeline-element-content .timeline-title {
			    font-size: .8rem;
			    text-transform: uppercase;
			    margin: 0 0 .5rem;
			    padding: 2px 0 0;
			    font-weight: bold
			}

			.vertical-timeline-element-content .vertical-timeline-element-date {
			    display: block;
			    position: absolute;
			    left: -90px;
			    top: 0;
			    padding-right: 10px;
			    text-align: right;
			    color: #adb5bd;
			    font-size: .7619rem;
			    white-space: nowrap
			}

			.vertical-timeline-element-content:after {
			    content: "";
			    display: table;
			    clear: both
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