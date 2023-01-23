<?php

template('header');

?>
<div class="album py-5 bg-light">
	<div class="container">

		<div class="row mt-3 mb-3">
			<div class="col">

				<p class="display-6 text-center ">Really Dumb Stats</p>
				<p class="lead text-center mb-5">I don't know what you're trying to prove except maybe that you need something more constructive to do with your time...</p>

				<div class="card mb-3">
			 		<div class="card-header">
						<h3>Who put the most movies on each wedge?</h3>
					</div>

					<div class="card-body">
						<p>Pie charts to illustrate who dominated each wedge.</p>
						<div class="row">
						<?php for($i = 1; $i <= 12; $i++):?>
						<div class="col-2">

							<?php
							$wedge_number = $i;
							$this_wedge = get_moviegoers_from_this_wedge($pdo, $wedge_number);
							asort($this_wedge);
							//print_r($this_wedge);
							$the_colors = Array();
							$the_names = Array();
							unset($this_wedge[0]);

							foreach($this_wedge as $key => $value){
								$the_colors[] = getMoviegoerColorById($key);
								$the_names[] = getMoviegoerById($key);
							}
							?>
							<strong>Wedge <?php echo $i;?></strong>
							<canvas id="wedge<?php echo $i;?>" width="250" height="250" style="position:relative; !important"></canvas>
							<script>
							var ctx = document.getElementById('wedge<?php echo $i;?>').getContext('2d');
							var myChart = new Chart(ctx, {
								type: 'pie',
								data: {
									labels: ['<?php echo implode("','", $the_names); ?>'],
										datasets: [{
											data: [<?php echo implode(',',$this_wedge); ?>],
											backgroundColor: ['#<?php echo implode("','#", $the_colors); ?>'],
											hoverOffset: 10
										}]
								},
								options: {
									layout: {
										padding: {
											left: 5,
											right: 5,
											top: 0
										}
									},
									plugins: {
										legend: {
											display: false
										}
									}
								}
							});
							</script>

						</div>
						<?php endfor;?>
						</div>
					</div>
				</div>

				<div class="card mb-3">
			 		<div class="card-header">
						<h3>How many minutes of content has been put on each wedge?</h3>
					</div>

					<div class="card-body">
							<div class="chart" style="height:25rem;">
								<table id="wedge_time" class="charts-css column show-labels show-data">
									<thead>
										<tr>
											<th scope="col">Wedge</th>
											<th scope="col">Minutes</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$max = 0;
										for($ii = 1; $ii <= 12; $ii++): ?>
											<?php
											$wedge_number = $ii;
											$wedge = get_movies_from_this_wedge($pdo,$wedge_number);
											$total_runtime = 0;

											foreach($wedge as $film_id){
												$total_runtime += get_movie_runtime($pdo, $film_id);

											}
											if($total_runtime > $max){
												$max = $total_runtime;
											}?>
											<tr>
												<th scope="row"> <?php echo $ii; ?> </th>
												<td style="--size:<?php echo round($total_runtime/$max,2); ?>; "><span class="data data_padding"><?php echo $total_runtime; ?></span></td>
											</tr>
										<?php endfor;?>
									</tbody>
								</table>
							</div>

					</div>
				</div>

				<div class="card mb-3">
					<div class="card-header">
						<h3>How many minutes of content has each viewer put on the wheel?</h3>
					</div>

					<div class="card-body">
						<div class="">
							<?php $viewer_time = get_viewers_time($pdo);
							arsort($viewer_time);
							unset($viewer_time[0]);
							$max = max($viewer_time);
							?>
							<div class="chart "style="height:25rem;">
								<table id="columns" class="charts-css column show-labels">
									<thead>
										<tr>
											<th scope="col">Person</th>
											<th scope="col">Minutes</th>
										</tr>
									</thead>
										<tbody>
											<?php foreach($viewer_time as $key => $value):?>
												<tr>
													<th scope="row"> <?php echo getMoviegoerById($key); ?> </th>
													<td style="--size:<?php echo round($value/$max,2); ?>; --color:#<?php echo getMoviegoerColorById($key); ?>"><span class="data data_padding"><?php echo $value; ?></span></td>
												</tr>
											<?php endforeach;?>
										</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>


	</div>
</div>

<?php template('footer');?>
