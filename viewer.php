<?php

require_once('common.php');

template('header');


if(isset($_GET['viewer'])){
	$viewer = $_GET['viewer'];
}
else {
	header('Location: viewers.php');
	exit;
}

?>

<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center ">Even More Details.</p>
		<p class="lead text-center ">For your convenience.</p>


		<div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-10 g-3 mt-5">

			<div class="col-12 mb-4">
				<div class="card">
					<div class="card-header bold text-white" style="background-color:#<?php echo getMoviegoerColorById($viewer);?>;" >
						<h3><?php echo getViewerName($viewer); ?></h3>
					</div>
					<div class="card-body">
						<ul>
							<?php

							$attend = countAttendance($viewer);
							$total_events = countWeeks();

							$myUnique = calculateMyUniquePicks($viewer);
							$myTotal = countMyTotalPics($viewer);

							$wins = winningPickStats($viewer);

							$picks = countMySpins($viewer);

							$spins = countMySpins_noChoice($viewer);

							?>
						 	<li><strong>Attendance:</strong> <?php echo $attend;?></li>
							<li><strong>Unique Picks:</strong> <?php echo $myUnique; ?></li>
							<li><strong>Total Picks:</strong> <?php echo $myTotal; ?></li>
							<?php if($myTotal == 0){$myTotal = 1;}?>
							<li><strong>Percent Unique:</strong> <?php echo round(($myUnique/$myTotal)*100,2);?>%</li>
							<li><strong>Wins:</strong> <?php echo $wins; ?></li>
							<li><strong>Win Percentage:</strong> <?php echo round(($wins/$total_events)*100,2);?>%</li>
							<li><strong>Win % for Attendance:</strong> <?php echo round(($wins/$attend)*100,2);?>%</li>
							<li>
								<?php

								$vy = get_viewers_years_single($viewer);
								if(!empty($vy)){
									$vy_count = count($vy);
								}
								else {
									$vy_count = 1;
								}

								echo 'Tends to pick movies that were released around'.round(array_sum($vy)/$vy_count);

								?>
							</li>
							<li><strong>Scribe: </strong><?php echo countScribe($viewer); ?></li>
							<li><strong>All Picks: </strong><?php echo $picks['total'];?></li>
							<li><strong>Spins: </strong><?php echo $spins['total'];?></li>
							<li><strong>Error Spins: </strong><?php echo $spins['bad'];?></li>
						</ul>
						<ul>
							<li><strong>Spun Numbers: </strong><?php //echo implode(", ", listOfSpunNumbersByViewer($viewer));?></li>
							<?php
								//print_r(graphSpunNumbersByViewer($id));
								$numbers = graphSpunNumbersByViewer($viewer);
								if(!empty($numbers)){
									$max = max($numbers);
									if($max == 0){$max = 1;}
								}
								else {
									$max = 1;
								}
							?>

							<div class="chart">
								<table id="column-<?php echo $viewer;?>" class="charts-css column show-labels show-data-on-hover">
									<thead>
										<tr>
											<th scope="col">Number</th>
											<th scope="col">Wins</th>
										</tr>
									</thead>
										<tbody style="height: 120px;">
											<?php foreach($numbers as $key => $value):?>
												<tr>
													<th scope="row"> <?php echo $key; ?> </th>
													<td style="--size:<?php echo round($value/$max,1); ?>;"><span class="data"><?php echo $value; ?></span></td>
												</tr>
											<?php endforeach;?>
										</tbody>
								</table>
							</div>

							<li>
								<strong>Spun People: </strong>
								<?php //echo implode(", ", getSpunViewers($viewer)); ?>
							</li>

							<?php

							$numbers = getSpunViewers_v2($viewer);

							if(!empty($numbers)){
								$max = max($numbers);
								if($max == 0){$max=1;}
							}
							else {
								$max = 1;
							}

							?>

							<div class="chart">
								<table id="column-<?php echo $viewer;?>" class="charts-css bar show-labels show-data-on-hover">
									<thead>
										<tr>
											<th scope="col">Number</th>
											<th scope="col">Wins</th>
										</tr>
									</thead>
										<tbody>
											<?php foreach($numbers as $key => $value):?>
												<tr>
													<th scope="row"> <?php echo $key; ?> </th>
													<td style="--size:<?php echo round($value/$max,2); ?>; --color:#<? echo getMoviegoerColorByName($key); ?>"><span class="data data_padding"><?php echo $value; ?></span></td>
												</tr>
											<?php endforeach;?>
										</tbody>
								</table>
							</div>

							<!--<li><strong>Spun Colors: </strong>
								<?php
								$colors = getSpunColors($viewer);
									foreach($colors as $color):?>
									<i class="fas fa-square" style="color:<?php echo $color;?>;"></i>
								<?php endforeach;?>
							</li>--!-->

						</ul>

						<?php

						$stats = count_viewer_services($viewer);

						$format = Array();
						$count = Array();
						$color = Array();
						foreach($stats as $key => $value){
							$format[] = $key;
							$count[] = $value;
							$color[] = get_service_color_v3($key);
						}

						if(!empty($format)): ?>
							<strong>Winning Services: </strong>
							<canvas id="myChart<?php echo $viewer;?>" width="250" height="250" style="position:relative; !important"></canvas>
							<script>
							var ctx = document.getElementById('myChart<?php echo $viewer;?>').getContext('2d');
							var myChart = new Chart(ctx, {
									type: 'doughnut',
									data: {
										labels: ['<?php echo implode("','", $format); ?>'],
											datasets: [{
												data: [<?php echo implode(',', $count); ?>],
												backgroundColor: ['<?php echo implode("','", $color); ?>'],
												hoverOffset: 10
											}]
									},
									options: {
										layout: {
											padding: {
												left: 30,
												right: 30,
												top: 10
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

						<?php endif; ?>
					</div>
				</div>
			</div>


				<div class="col-12 mb-4">
					<div class="card">
						<div class="card-header bold text-white" style="background-color:#<?php echo getMoviegoerColorById($viewer);?>;" >
							<h3>Films</h3>
						</div>
						<div class="card-body">
							<?php

							$watchedFilmList = listWatchedMovies();
							$allUsersPicks = listMyTotalPicksReal($viewer);
							$allUserPicks2 = Array();
							foreach($allUsersPicks as $aPick){
								$allUserPicks2[] = $aPick['filmID'];
							}
							//$allUserPicks2 = array_unique($allUserPicks2);
							$allUserPicks3 = array_count_values($allUserPicks2);
							arsort($allUserPicks3);

							?>
							<ul>
								<h3>Unwatched Picks</h3>
								<?php

								foreach($allUserPicks3 as $key => $value){
									if(!in_array($key, $watchedFilmList)){
									 	echo '<li>'.getMovieById($key).'<em>('.$value.')</em></li>';
									}
								}

								?>
							</ul>
						</div>
					</div>
				</div>


		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#movies').DataTable(
		{
			"pageLength": 100,
			"lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
			"order": [[ 1, "desc" ]]
		}
	);
} );
</script>


<?php template('footer');?>
