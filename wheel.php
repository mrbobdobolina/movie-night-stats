<?php

require_once('common.php');

template('header');

?>
<div class="album py-5 bg-light">
	<div class="container">

		<div class="row mt-3 mb-3">
			<div class="col">

				<p class="display-6 text-center ">How We Chose Our Movies</p>
				<p class="lead text-center "><i class="fa-solid fa-dice-d12"></i> Roll a thing, <i class="fa-solid fa-arrows-spin"></i> spin a thing, <i class="fa-solid fa-thought-bubble"></i> think a thing. </p>

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

		<div class="row">
			<div class="col m-5">

				<div class="card mb-4" >
  				<div class="row g-0">
    				<div class="col-md-4">
      				<img src="images/wheels/wheel_v1.jpg" class="img-fluid rounded-start" alt="Wheel Version 1">
    				</div>
    				<div class="col-md-8">
      				<div class="card-body">
        				<h5 class="card-title bold">Wheel Version 1.1</h5>
        				<p class="card-text">Wheel version 1 was made from a $3 clock in the entrance of target and a fidget spinner bearing. Small brad nails were used as pegs and the flipper was crafted from hardwood. Version 1.0 broke on it's first spin. Several brad nails were dislodged upon contact with the flipper. The flipper also broke. The original flipper was replaced with a thin piece of project board and the nails were replaced with wooden dowel pegs and thus Version 1.1 was born.</p>
      				</div>
    				</div>
  				</div>
				</div>

				<div class="card mb-4" >
  				<div class="row g-0">
    				<div class="col-md-4">
      				<img src="images/wheels/wheel_v2.jpg" class="img-fluid rounded-start" alt="Wheel Version 2">
    				</div>
    				<div class="col-md-8">
      				<div class="card-body">
        				<h5 class="card-title bold">Wheel Version 2</h5>
        				<p class="card-text">Wheel version 2 was build using a piece of plywood. It was used for 17 spins before it was found to be weighted and most likely to land on the number 8. While it may be possible to reblance the wheel at some point, no efforts have been made at this time.</p>
      				</div>
    				</div>
  				</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/wheel_v3.jpg" class="img-fluid rounded-start" alt="Wheel Version 3">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">Wheel Version 3</h5>
								<p class="card-text">Wheel version 3 was designed using particleboard, which should have a more uniform density than plywood. It used a similar flipper and axel to the other two. It was designed to be 18 inches in diameter, which became an issue when drilling the center hole. The wheel is heavy and does not sit level as it rotates. The balance was fine-tuned using tacks along the perimeter, though the level of balance is still being debated. Wheel 3 broke while an attempt was made to update the spinning mechanism. It has not been repaired.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/d12.jpg" class="img-fluid rounded-start" alt="Dice">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">Die (or dice)</h5>
								<p class="card-text">A single 12-sided die is often used. There is no single die designated for rolling. Dice rolled include a large 5" foam die and smaller normal dice. The only requirements for dice is that they be 12-sided and not weighted.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/bobbot.jpg" class="img-fluid rounded-start" alt="BobBot">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">Bobbot</h5>
								<p class="card-text">Bobbot was (is?) a Discord Bot built by TV to allow users to spin electronically. The bot has been offline since July 2020.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/viewerchoice.jpg" class="img-fluid rounded-start" alt="Viewer Choice">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">Viewer Choice</h5>
								<p class="card-text">Occasionally we decide it's better not to leave things up to chance. Typically this means only one person is present for movie night or everyone attending wants to watch the same thing.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/wheelofsus.jpg" class="img-fluid rounded-start" alt="Wheel of Sus">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">wheelofsus</h5>
								<p class="card-text">Originally created for specialized games of Among Us, wheelofsus is a propriatary interactive virtual wheel that can be customized for many different events.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/random_org.jpg" class="img-fluid rounded-start" alt="Random.org">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold"><a href="https://random.org">Random.org</a></h5>
								<p class="card-text">Random.org offers several different features for choosing items randomly.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4" >
					<div class="row g-0">
						<div class="col-md-4">
							<img src="images/wheels/pye_spinner.jpg" class="img-fluid rounded-start" alt="PYE Games Spinner die">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title bold">PYE Spinner Die</h5>
								<p class="card-text">This spinning die is from <a href="https://www.pyegames.com/">PYE Games</a>.</p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

<?php template('footer');?>
