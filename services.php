<?php require_once("header.php"); ?>

  <div class="album py-5 bg-light">
    <div class="container">
			<p class="display-6 text-center ">The Services</p>
			<p class="lead text-center ">Things That Cost $$$ Every Month</p>
			<br />
			
			<?php $service_data = get_service_stats(); ?>
			
			<?php 
			$format = Array();
			$count = Array();
			
			/*$colors = Array("Disney+" => "rgba(44,43,191,1)", 
				"Netflix" => "rgba(229,9,20,1)", 
				"Hulu" => "rgba(28,231,131,1)", 
				"Digital File" => "rgba(237,182,23,1)",
				"DVD" => "rgba(166,170,155,1)",
				"Prime" => "rgba(0,168,255,1)",
				"HBO Max" => "rgba(91,28,230,1)",
				"iTunes Rental" => "rgba(136,136,136,1)",
				"Starz" => "rgba(0,0,0,1)",
				"HBO Now" => "rgba(0,0,0,1)",
				"Redbox" => "rgba(227,32,69,1)",
				"YouTube Movies" => "rgba(255,0,0,1)",
				"Bluray" => "rgba(0,144,206,1)",
				"Streaming" => "rgba(99,44,140,1)",
				"Steam" => "rgba(27,40,56,1)",
				"Apple TV+" => "rgba(11,11,12,1)",
				"Comedy Central" => "rgba(253,198,0,1)");*/
				
				$colors = get_service_color();
				
			foreach($service_data as $item){
				$format[] = $item['format'];
				$count[] = $item['COUNT(*)'];
				
				$color[] = $colors[$item['format']];
				
			}
			
			?>
				
				<div class="row mt-3">
				
	<canvas id="myChart" width="400" height="200" style="position:relative; !important"></canvas>
	<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['<?php echo implode($format, "','"); ?>'],
	        datasets: [{
	            label: '# of Events',
	            data: [<?php echo implode($count, ','); ?>],
	            backgroundColor: [
	                '<?php echo implode($color, "','"); ?>'
	            ]
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
	</script>
				

							<p class="lead text-center mt-5">The time we've spent with each.</p>
				<?php $minutes_watched = count_minutes_per_service(); 
				foreach($minutes_watched as $item){
					$format_m[] = $item['format'];
					$count_m[] = $item['SUM(`runtime`)'];
				
					$color_m[] = $colors[$item['format']];
				
				}
				
				?>
				
				<canvas id="myTimeChart" width="400" height="200" style="position:relative; !important"></canvas>
				<script>
				var ctx = document.getElementById('myTimeChart').getContext('2d');
				var myChart = new Chart(ctx, {
				    type: 'bar',
				    data: {
				        labels: ['<?php echo implode($format_m, "','"); ?>'],
				        datasets: [{
				            label: 'Minutes Watched on Each Service',
				            data: [<?php echo implode($count_m, ','); ?>],
				            backgroundColor: [
				                '<?php echo implode($color_m, "','"); ?>'
				            ]
				        }]
				    },
				    options: {
				        scales: {
				            y: {
				                beginAtZero: true
				            }
				        }
				    }
				});
				</script>
									
				
			</div>
    </div>
  </div>

</main>

<footer class="text-muted py-5">
  <div class="container">
								Version <?php echoVersionNumber(); ?> <a href="changelog.php">Changelog</a>
   </div>
</footer>


    <script src="bootstrap5/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

      
  </body>
</html>
