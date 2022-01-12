<?php

require_once('common.php');

template('header');

?>

<div class="album py-5 bg-light">
  <div class="container">
		<p class="display-6 text-center ">The Services</p>
		<p class="lead text-center ">Things That Cost $$$ Every Month</p>

		<?php

		$service_data = get_service_stats();

		$format = Array();
		$count = Array();

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
		        labels: ['<?php echo implode("','", $format,); ?>'],
		        datasets: [{
	            label: '# of Events',
	            data: [<?php echo implode(',', $count); ?>],
	            backgroundColor: [
                '<?php echo implode("','", $color); ?>'
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

			<?php

			$minutes_watched = count_minutes_per_service();
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
		        labels: ['<?php echo implode("','", $format_m); ?>'],
		        datasets: [{
	            label: 'Minutes Watched on Each Service',
	            data: [<?php echo implode(',', $count_m); ?>],
	            backgroundColor: [
                '<?php echo implode("','", $color_m); ?>'
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

<?php template('footer');?>
