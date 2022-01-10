<?php

require_once('common.php');

template('header');

?>

<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center ">The People</p>
		<p class="lead text-center ">(They used to be your friends, but then you made them watch <span class="bg-dark text-white px-1"><strong>[REDACTED]</strong></span>.)</p>

		<?php

		$streakers = get_streakers();
		$time_watched = viewer_watchtime();

		?>

		<div class="row justify-content-around">
			<div class="alert text-center col-5 text-white" role="alert" style="background-color:#<?php echo getMoviegoerColorById($streakers['current']['viewer']);?>;">
				<?php echo "<strong>Current Winning Streak: </strong>" . getMoviegoerById($streakers['current']['viewer']) .	" with "	. $streakers['current']['count']; " wins! "; ?>
			</div>
			<div class="alert text-center col-5 text-white" role="alert" style="background-color:#<?php echo getMoviegoerColorById($streakers['longest']['viewer']);?>;">
				<?php echo "<strong>Longest Winning Streak: </strong>" . getMoviegoerById($streakers['longest']['viewer']) .	" with "	. $streakers['longest']['count']; " wins! "; ?>
			</div>
		</div>

		<div class="row mt-3">

			<table id="movies" class="table table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Atnd</th>
						<th class="text-end">
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of events a viewer has been to.">
								%
							</div>
						</th>
						<th class="text-end">
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of unique movies a user has put on the wheel.">
								<i class="fas fa-fingerprint"></i> <i class="fas fa-film"></i>
							</div>
						</th>
						<th class="text-end">
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of total movies a user has put on the wheel.">
								<i class="fal fa-ballot-check" ></i> <i class="fas fa-film"></i>
							</div>
						</th>
						<th class="text-end">
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="% of Unique movies a user has put on the wheel.">
								<i class="fas fa-fingerprint"></i> %
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of times a viewer's movie has been picked for movie night.">
								<i class="fas fa-trophy"></i>
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The percent of movie nights a viewer has won.">
								<i class="fas fa-trophy"></i> %
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title=" The percentage of attended movie nights that a viewers movie has won.">
								<i class="fas fa-trophy" ></i>/Atnd
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="Streak: The most consecutive events that a viewer has had their movie chosen.">
								<i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i>
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The longest a viewer has gone without winning (only counting attended events.)">
								<i class="fas fa-cactus"></i>
							</div>
						</th>
						<th aria-sort="ascending">
							Last Spin
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of times a user has spun a wheel or rolled a die.">
								<i class="fas fa-sync"></i>
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of times a user has chosen a film: the number of spins plus viewers choice.">
								<i class="fas fa-sync"></i>+<i class="fas fa-hand-point-up"></i>
							</div>
						</th>
						<th class="text-end">
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of minutes viewer has spent watching films.">
								<i class="far fa-stopwatch"></i>
							</div>
						</th>
						<th>
							<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="Average moving rating across all films viewer placed on wheel.">
								<i class="fas fa-star-half-alt"></i>%
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$viewer = getListOfViewers('attendance');
					$total_events = countWeeks();

					foreach($viewer as $person): ?>

						<tr style="background-color:<?php echo HTMLToRGB($person['color']);?>;">
							<?php

							$attend = countAttendanceReal($person['id']);

							$myUnique = calculateMyUniquePicks($person['id']);
							$myTotal = countMyTotalPics($person['id']);

							$wins = winningPickStats($person['id']);

							$spins = countMySpins_noChoice($person['id']);

							$picks = countMySpins($person['id']);

							?>
							<td style="background-color:#<?php echo $person['color'];?>;" class="bold text-white"><?php echo $person['name'];?></td>
						 	<td class="text-end"><?php echo $attend;?></td>
						 	<td class="text-end"><em><?php echo round(($attend/$total_events)*100, 2)?>%</em> </td>
							<td class="text-end"><?php echo $myUnique; ?></td>
							<td class="text-end"><?php echo $myTotal; ?></td>
							<td class="text-end">
								<?php
								if($myTotal == 0){ $myTotal = 1;}
								echo round(($myUnique/$myTotal)*100,2);
								?>%
							</td>
							<td class="text-end"><?php echo $wins; ?></td>
							<td class="text-end"><?php echo round(($wins/$total_events)*100,2);?>%</td>
							<td class="text-end"><?php echo round(($wins/$attend)*100,2);?>%</td>
							<td class="text-end"><?php echo find_my_longest_streak($person['id']); ?></td>
							<td class="text-end"><?php echo get_dry_spell($person['id']); ?></td>
							<td class="text-end"><?php echo last_spin_date($person['id']); ?></td>
							<td class="text-end"><?php echo $spins['total'];?></td>
							<td class="text-end"><?php echo $picks['total'];?></td>
							<td class="text-end"><?php echo $time_watched[$person['id']];?></td>
							<td class="text-end"><?php echo get_viewer_ratings_real($person['id']);?>%</td>

						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		</div>

		<div class="accordion mt-1" id="accordionExample">
			<div class="accordion-item">
				<h2 class="accordion-header" id="headingOne">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						 *Notes and definitions for above table.
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<ul>
							<li><strong>Name:</strong> Name. Name of viewer.</li>
							<li><strong>Atnd:</strong> Attendance. The number of events a viewer has been to.</li>
							<li><strong>%</strong> Attendance Percentage. The percent of total movie nights a viewer has been in attendance.</li>
							<li><strong><i class="fas fa-fingerprint"></i></strong> Unique Movies. The number of unique movies a user has put on the wheel.</li>
							<li><strong><i class="fal fa-ballot-check"></i></strong> Total Movies. The number of total movies a user has put on the wheel.</li>
							<li><strong><i class="fas fa-fingerprint"></i>%</strong> % of Unique movies a user has put on the wheel.</li>
							<li><strong><i class="fas fa-trophy"></i></strong> Wins: The number of times a viewer's movie has been picked for movie night.</li>
							<li><strong><i class="fas fa-trophy"></i> %:</strong> The percent of movie nights a viewer has won.</li>
							<li><strong><i class="fas fa-trophy"></i>/Atnd:</strong> The percentage of attended movie nights that a viewers movie has won.</li>
							<li><strong><i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i></strong> Streak: The most consecutive events that a viewer has had their movie chosen.</li>
							<li><strong><i class="fas fa-cactus"></i></strong> Dry: The longest a viewer has gone without winning (only counting attended events.)</li>
							<li><strong>Last Spin:</strong> The date if a viewers last spin/roll. Used to determine who is up next.</li>
							<li><strong><i class="fas fa-sync"></i></strong> Spins: The number of times a user has spun a wheel or rolled a die.</li>
							<li><strong><i class="fas fa-sync"></i>+<i class="fas fa-hand-point-up"></i></strong> Spins + Picks The number of times a user has chosen a film, the number of spins plus viewers choice.</li>
							<li><strong><i class="far fa-stopwatch"></i></strong> The number of minutes viewer has spent watching films.</li>
							<li><strong><i class="fas fa-star-half-alt"></i>%</strong> Average Moving Rating across all picked films.</li>
						<ul>
					</div>
				</div>
			</div>
		</div>


		<div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3 mt-5">
			<?php foreach($viewer as $person): ?>
				<div class="col-3 mb-4">
					<div class="card">
						<div class="card-header bold text-white" style="background-color:#<?php echo $person['color'];?>;" >
							<h3><?php echo $person['name']; ?></h3>
						</div>
						<div class="card-body">
							<ul>
								<li>
									<strong>Spun Numbers: </strong><?php //echo implode(", ", listOfSpunNumbersByViewer($person['id']));?>
								</li>
								<?php //print_r(graphSpunNumbersByViewer($id));
								$numbers = graphSpunNumbersByViewer($person['id']);
								if(!empty($numbers)){
									$max = max($numbers);
									if($max == 0){$max = 1;}
								}
								else {
									$max = 1;
								}
								?>

								<div class="chart">
									<table id="column-<?php echo $person['id'];?>" class="charts-css column show-labels show-data-on-hover">
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
													<td style="--size:<?php echo round($value/$max,2); ?>;"><span class="data"><?php echo $value; ?></span></td>
												</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>

								<li><strong>Spun People: </strong></li>
								<?php //echo implode(", ", getSpunViewers($person['id']));

								$numbers = getSpunViewers_v2($person['id']);

								if(!empty($numbers)){
									$max = max($numbers);
									if($max == 0){$max=1;}
								}
								else {
									$max = 1;
								}

								?>

								<div class="chart">
									<table id="column-<?php echo $person['id'];?>" class="charts-css bar show-labels show-data">
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

							</ul>



							<?php

							$stats = count_viewer_services($person['id']);

							$format = Array();
							$count = Array();
							$color = Array();
							foreach($stats as $key => $value){
								$format[] = $key;
								$count[] = $value;
								$color[] = get_service_color($key);
							}

							if(!empty($format)): ?>
								<strong>Winning Services: </strong>
								<canvas id="myChart<?php echo$person['id'];?>" width="250" height="250" style="position:relative; !important"></canvas>
								<script>
								var ctx = document.getElementById('myChart<?php echo$person['id'];?>').getContext('2d');
								var myChart = new Chart(ctx, {
									type: 'doughnut',
									data: {
										labels: ['<?php echo implode($format, "','"); ?>'],
											datasets: [{
												data: [<?php echo implode($count, ','); ?>],
												backgroundColor: ['<?php echo implode($color,	"','"); ?>'],
												hoverOffset: 10
											}]
									},
									options: {
										layout: {
											padding: {
												left: 30,
												right: 30,
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

							<?php endif; ?>
							<a href="viewer.php?viewer=<?php echo $person['id']; ?>">More Details</a>
						</div>
					</div>
				</div>
			<?php endforeach;?>



		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#movies').DataTable(
		{
			"searching":false,
			"paging": false,
			"lengthChange": false,
			"order": [[ 1, "desc" ]],
			"columnDefs": [
				{ "orderSequence": [ "desc", "asc", "asc" ], "targets": [ 11 ] },
			]
		}
	);
} );

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>

<?php template('footer');?>
