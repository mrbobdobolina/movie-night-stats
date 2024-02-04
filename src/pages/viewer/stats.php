<div class="container my-4">
	<?php

	$viewer_list = new Viewer_List();
	$viewer_list->init();

	$event_list = new Event_List($viewer_list);
	$event_list->init();
	$count_events = count($event_list->events());


	$viewer_list->event_list = $event_list;

	$viewer_stats = $viewer_list->stats_by_viewer();

	if (array_key_exists((int)$_GET['viewer'], $viewer_stats)) {
		$viewer_id = (int)$_GET['viewer'];
		$this_viewer = $viewer_list->get_by_id($viewer_id);
		$this_viewer_stats = $viewer_stats[$viewer_id];
		$viewer = $viewer_id; // TODO: Remove This
	}
	else {
		header('Location: list');
		exit;
	}


	$attendance_count = count($this_viewer_stats['attendance']);
	$unique_count = count($this_viewer_stats['media']);
	$wedges_count = count($this_viewer_stats['wedges']);
	$wins_count = count($this_viewer_stats['wins']);
	$spin_count = count($this_viewer_stats['spins']);

	// Average Year

	$average_year_count = 0;
	$average_year_total = 0;
	foreach ($this_viewer_stats['media'] as $media) {
		$average_year_count++;
		$average_year_total += $media['item']->year;
	}
	$average_year = ( $average_year_count ) ? round($average_year_total / $average_year_count, 0) : '-';

	// Win Streaks
	$longest_win_streak = 0;
	$longest_lose_streak = 0;

	foreach ($this_viewer_stats['streak']['win'] as $win_streak) {
		if (count($win_streak) >= $longest_win_streak) {
			$longest_win_streak = count($win_streak);
		}
	}
	foreach ($this_viewer_stats['streak']['lose'] as $lose_streak) {
		if (count($lose_streak) >= $longest_lose_streak) {
			$longest_lose_streak = count($lose_streak);
		}
	}

	?>

	<style>
		.card-header {
			background-color: #<?php echo $this_viewer->color;?>;
			color: white;
		}
	</style>

	<a href="/viewer/list" class="btn btn-primary mb-3">Back to List</a>
	<div class="row">
		<div class="col-12">
			<h1
				class="alert text-white text-center fw-bold"
				style="background-color:#<?php echo $this_viewer->color; ?>">
				<?php echo $this_viewer->name; ?>
			</h1>
		</div>
	</div>
	<div class="row">

		<div class="col-12 col-md-6 col-lg-4">
			<div class="row row-cols-1">


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Info
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Name:</div>
									<div class="col"><?php echo $this_viewer->name; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Attendance:</div>
									<div class="col"><?php echo $attendance_count; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">First Seen:</div>
									<div class="col">
										<?php echo $this_viewer_stats['attendance'][$attendance_count - 1]->date->short(); ?>
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Last Seen:</div>
									<div
										class="col"><?php echo $this_viewer_stats['attendance'][0]->date->short(); ?></div>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Picks
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Total:</div>
									<div class="col"><?php echo $wedges_count; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Unique:</div>
									<div class="col"><?php echo $unique_count; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">% Unique:</div>
									<div class="col">
										<?php echo ( $wedges_count ) ? round(( $unique_count / $wedges_count ) * 100, 2) : '-'; ?>
										%
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Average Year:</div>
									<div class="col"><?php echo $average_year; ?></div>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Wins
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Total:</div>
									<div class="col"><?php echo $wins_count; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">% / Total Events:</div>
									<div class="col">
										<?php echo ( $count_events ) ? round(( $wins_count / $count_events ) * 100, 2) : '-'; ?>
										%
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">% / Attendance:</div>
									<div class="col">
										<?php echo ( $attendance_count ) ? round(( $wins_count / $attendance_count ) * 100, 2) : '-'; ?>
										%
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Streaks
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Win:</div>
									<div class="col">
										<?php echo $longest_win_streak; ?>
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Win with Viewer Choice:</div>
									<div class="col"></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Win when Attending:</div>
									<div class="col">
										<?php //echo count_viewer_win_streak_when_attending_and_not_viewer_choice($pdo, $viewer)['count']; ?>
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Lose:</div>
									<div class="col"><?php echo $longest_lose_streak; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Lose with Viewer Choice:</div>
									<div class="col"></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Longest Lose when Attending:</div>
									<div class="col"></div>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<?php
						$picks = countMySpins($viewer);
						$spins = countMySpins_noChoice($viewer);
						?>
						<div class="card-header h3">
							Stats
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Scribe:</div>
									<div class="col"><?php //echo count_scribing($pdo, $viewer); ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">All Picks:</div>
									<div class="col"><?php echo $picks['total']; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Total Spins:</div>
									<div class="col"><?php echo $spin_count; ?></div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col fw-bold">Error Spins:</div>
									<div class="col"><?php echo $spins['bad']; ?></div>
								</div>
							</li>
						</ul>
					</div>
				</div>


			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-4">
			<div class="row row-cols-1">


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Spun Numbers
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<?php
								$numbers = graphSpunNumbersByViewer($viewer);
								if (!empty($numbers)) {
									$max = max($numbers);
									if ($max == 0) {
										$max = 1;
									}
								}
								else {
									$max = 1;
								}
								?>

								<div class="chart">
									<table
										id="column-<?php echo $viewer; ?>"
										class="charts-css column show-labels show-data">
										<thead>
										<tr>
											<th scope="col">Number</th>
											<th scope="col">Wins</th>
										</tr>
										</thead>
										<tbody style="height: 120px;">
										<?php foreach ($numbers as $key => $value): ?>
											<tr>
												<th scope="row"> <?php echo $key; ?> </th>
												<td style="--size:<?php echo round($value / $max, 1); ?>;">
													<span class="data"><?php echo $value; ?></span></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Spun People
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<?php

								$numbers = getSpunViewers_v2($viewer);

								if (!empty($numbers)) {
									$max = max($numbers);
									if ($max == 0) {
										$max = 1;
									}
								}
								else {
									$max = 1;
								}


								$the_peoples = [];
								$the_counts = [];
								$the_colors = [];
								?>

								<div class="chart">
									<table
										id="column-<?php echo $viewer; ?>" class="charts-css bar show-labels show-data">
										<thead>
										<tr>
											<th scope="col">Number</th>
											<th scope="col">Wins</th>
										</tr>
										</thead>
										<tbody>
										<?php foreach ($numbers as $key => $value): ?>
											<?php
											$the_peoples[] = $key;
											$the_counts[] = $value;
											$the_colors[] = getMoviegoerColorByName($key); ?>
											<tr>
												<th scope="row"> <?php echo $key; ?> </th>
												<td style="--size:<?php echo round($value / $max, 2); ?>; --color:#<?php echo getMoviegoerColorByName($key); ?>">
													<span class="data data_padding"><?php echo $value; ?></span></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</li>
						</ul>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<canvas
									id="spinnychart"
									width="250"
									height="250"
									style="position:relative; !important"></canvas>
								<script>
									var ctx = document.getElementById('spinnychart').getContext('2d');
									var myChart = new Chart(ctx, {
										type: 'pie',
										data: {
											labels: ['<?php echo implode("','", $the_peoples); ?>'],
											datasets: [
												{
													data: [<?php echo implode(',', $the_counts); ?>],
													backgroundColor: ['#<?php echo implode("','#", $the_colors); ?>'],
													hoverOffset: 10,
												},
											],
										},
										options: {
											layout: {
												padding: {
													left: 30,
													right: 30,
													top: 0,
												},
											},
											plugins: {
												legend: {
													display: true,
												},
											},
										},
									});
								</script>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Spun Methods
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="chart">
									<table id="method-chart" class="charts-css bar show-labels show-data">
										<thead>
										<tr>
											<th>Method</th>
											<th>Count</th>
										</tr>
										</thead>
										<tbody>
										<?php //$methods = count_viewer_spin_methods($pdo, $viewer);
										//$m_max = $methods[0]['count(*)']
										$methods = [];
										?>
										<?php foreach ($methods as $method): ?>
											<tr>
												<th scope="row"> <?php echo $method['selection_method']; ?> </th>
												<td style="--size:<?php echo round($method['count(*)'] / $m_max, 2); ?>;w">
													<span
														class="data data_padding"><?php echo $method['count(*)']; ?></span>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Winning Services
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<?php

								$stats = count_viewer_services($viewer);

								$format = [];
								$count = [];
								$color = [];
								foreach ($stats as $key => $value) {
									$format[] = $key;
									$count[] = $value;
									$color[] = get_service_color_v3($key);
								}

								if (!empty($format)): ?>
									<canvas
										id="myChart<?php echo $viewer; ?>"
										width="250"
										height="250"
										style="position:relative; !important"></canvas>
									<script>
										var ctx = document.getElementById('myChart<?php echo $viewer;?>').getContext(
											'2d');
										var myChart = new Chart(ctx, {
											type: 'doughnut',
											data: {
												labels: ['<?php echo implode("','", $format); ?>'],
												datasets: [
													{
														data: [<?php echo implode(',', $count); ?>],
														backgroundColor: ['<?php echo implode("','", $color); ?>'],
														hoverOffset: 10,
													},
												],
											},
											options: {
												layout: {
													padding: {
														left: 30,
														right: 30,
														top: 10,
													},
												},
												plugins: {
													legend: {
														display: false,
													},
												},
											},
										});
									</script>

								<?php endif; ?>
							</li>
						</ul>
					</div>
				</div>


			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="row row-cols-1">


				<div class="col mb-3">
					<div class="card">
						<div class="card-header h3">
							Unwatched Picks
						</div>
						<div class="card-body">
							<?php

							$watchedFilmList = listWatchedMovies();
							$allUsersPicks = listMyTotalPicksReal($viewer);
							$allUserPicks2 = [];
							foreach ($allUsersPicks as $aPick) {
								$allUserPicks2[] = $aPick['filmID'];
							}
							//$allUserPicks2 = array_unique($allUserPicks2);
							$allUserPicks3 = array_count_values($allUserPicks2);
							arsort($allUserPicks3);

							?>


							<table id="movies" class="table table-striped">
								<thead>
								<tr>
									<td><strong><i class="fa-regular fa-photo-film-music"></i></strong></td>
									<td><strong>Movie Title</strong></td>
									<td><strong>Times on Wheel</strong></td>
								</tr>
								</thead>
								<tbody>
								<?php
								foreach ($allUserPicks3 as $key => $value) {
									if (!in_array($key, $watchedFilmList)) {
										echo '<tr><td class="text-center"><i class="fa fa-' . get_type_by_id($pdo, $key) . '"></i></td><td>' . get_movie_by_id($pdo, $key) . '</td> <td>' . $value . '</td></tr>';
									}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>


	<script>
		$(function () {
			$('#movies').DataTable(
				{
					'pageLength': 25,
					'lengthMenu': [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, 'All']],
					'order': [[2, 'desc']],
				},
			);
		});
	</script>

</div>
