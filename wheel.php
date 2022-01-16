<?php

require_once('common.php');

template('header');

?>
<div class="album py-5 bg-light">
	<div class="container">

		<div class="row mt-3 mb-3">
			<div class="col">

				<p class="display-6 text-center ">How We Chose Our Movies</p>
				<p class="lead text-center ">Roll a thing, spin a thing, think a thing. </p>

				<?php
					$service_data = get_selector_stats();
					
					$format = Array();
					$count = Array();

					foreach($service_data as $item){
						$format[] = $item['selection_method'];
						$count[] = $item['COUNT(*)'];

					}

				?>

				<canvas id="myChart" width="400" height="200" style="position:relative; !important"></canvas>
				<script>
					var ctx = document.getElementById('myChart').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['<?php echo implode("','", $format); ?>'],
							datasets: [{
								label: '# of Events',
								data: [<?php echo implode(',', $count ); ?>],
								backgroundColor: [
									'rgba(216,66,45,1)'
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

		<div class="row my-3">
			<div class="col">

				<p class="display-6 text-center mb-5 mt-5">Virtually meaningless, but still fun to look at.</p>

				<div class="card">
			 		<div class="card-header">
						<h3>The Great Number-Off: Which Numbers have fared best in the matchups?</h3>
					</div>

					<div class="card-body">
						<?php $error_spin_list = getErrorSpins(); ?>

						<div class="">
							<table class="table">
								 <thead>
									<tr>
										<th class="text-center" style="width: 10%">Number</th>
										<th class="text-center" style="width: 10%">Spins</th>
										<th class="text-center" style="width: 10%">Percent</th>
										<th class="text-center" style="width: 70%">Visual</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$total = countSpins() + countErrorSpins();
										for($i = 1; $i <= 12; $i++){
											$wins = countWinsForNumber($i);
											$wins_with_error = countWinsForNumber($i) + $error_spin_list[$i];
											$percent = round(($wins/$total)*100, 0);
											$errorPercent = round(($error_spin_list[$i]/$total)*100, 0);
											?>
											<tr>
												<td class="text-center"><?php echo $i;?></td>
												<td class="text-center"><?php echo $wins_with_error;?></td>
												<td class="text-end"><?php echo $percent + $errorPercent;?>%</td>
												<td >
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $errorPercent; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
											</tr>
											<?php
										}
									?>
									<tr>
										<td>Total:</td>
										<td	class="text-center"><?php echo $total; ?></td>
										<td class="text-end">Error Rate: <?php echo round((countErrorSpins()/$total)*100);?>%</td>
										<td>
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: <?php echo round((countSpins()/$total)*100); ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
												<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo round((countErrorSpins()/$total)*100); ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>

							<p>*Red indicates an error. An error occurs when the winning movie is not available to be watched and another movie must be picked.</p>
						</div>
					</div>
				</div>

			</div>
		</div>

		<p class="display-6 text-center mb-4 mt-5">The totally "unbiased" tools we use.</p>

			<div class="row row-cols-2 row-cols-md-3 row-cols-md-4 row-cols-xl-4 g-5 ">

			<?php
				$tools = getSelectionTypes();
				$wheel_color = getWheelColors();

				foreach($tools as $a_tool):
			 		$numbers = getNumbersFromTool($a_tool);
					$total_spins = array_sum($numbers);
					$max = max($numbers);

					?>

					<div class="col">
						<div class="card">
							<div class="card-header">
								<h3><?php echo $a_tool; ?></h3>
							</div>
							<div class="card-body">
								<p>
									<strong>Total Uses:</strong> <?php echo $total_spins; ?> (<?php echo round(($total_spins/$total)*100);?>%)
								</p>
								<table id="column-<?php echo $a_tool;?>" class="charts-css bar show-labels show-data data-spacing-2">
									<thead>
										<tr>
											<th scope="col">Number</th>
											<th scope="col">Wins</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($numbers as $key => $wedge): ?>
											<tr>
												<th scope="row text-end"> <?php echo $key; ?></th>
												<td style="--size:<?php echo round(($wedge/$max),2); ?>; --color:<?php echo $wheel_color[$a_tool][$key]; ?>"><span class="data" style="padding-right:3px;"><?php echo $wedge; ?> </span></td>
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endforeach;?>


		</div>
	</div>
</div>

<?php template('footer');?>
