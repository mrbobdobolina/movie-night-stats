<?php

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

		$colors = get_service_color_v3();

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


			<p class="lead text-center mt-5">The time we've clocked on each service.</p>

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

  <div id="mwo" class="row pt-5 justify-content-center">
    <div class="col-7">
    <h3>Movies watched on</h3>
    <?php
    $services = getListOfServices('name','ASC');

    $servicesSelect = "<option disabled selected>All Services</option>";

    foreach($services as $aService){
    	$servicesSelect .= "<option value=\"" . $aService['name'] . "\">" . $aService['name'] . "</option>";
    }
    ?>

<div class="col-12 mb-3">
  <select id="gender" class="form-control form-select">
      <?php echo $servicesSelect; ?>
  </select>
</div>

  <table class="dynamicTable table">
      <!-- Table heading -->
          <thead>
              <tr>
                <th>Date</th>
                  <th>Movie Title</th>
                  <th>Service</th>
              </tr>
          </thead>
      <tbody>
        <?php
          $all_winners = list_winning_films_and_service_v2($pdo);

          foreach($all_winners as $a_winner):?>
          <tr>
              <td><?php echo $a_winner['date']; ?></td>
              <td><?php echo get_movie_by_id($pdo,$a_winner['winning_film']); ?></td>
              <td><?php echo $a_winner['format']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <!-- // Table body END -->
  </table>

  <script>
$("#gender").on("change",
             function(){
                 var a = $(this).find("option:selected").html();

                 $("table tr td").each(
                     function(){
                         if($(this).html() != a){
                             $(this).parent().hide();
                         }
                         else{
                             $(this).parent().show();
                         }
                     });
             });
      </script>

  </div>
  </div>



  </div>
</div>

<?php template('footer');?>
