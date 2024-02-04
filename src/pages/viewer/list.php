<div class="container my-4">
<?php

$viewer_list = new Viewer_List();
$viewer_list->init();

$event_list = new Event_List($viewer_list);
$event_list->init();
$count_events = count($event_list->events());


$viewer_list->event_list = $event_list;

$viewer_stats = $viewer_list->stats_by_viewer();

?>

<h1 class="text-center">The People</h1>
<p class="lead text-center ">(They used to be your friends, but then you made them watch
	<span class="bg-dark text-white px-1"><strong>[REDACTED]</strong></span>.)
</p>

<?php
//$streakers = get_streakers();
$time_watched = viewer_watchtime();
//$viewers_longest_streaks = find_longest_streak_v2($pdo);
//$longest_streak = max($viewers_longest_streaks);
//$longest_streak_key = array_search(max($viewers_longest_streaks), $viewers_longest_streaks);
//$current_streak = get_current_streak($pdo);
?>

<div class="row justify-content-around">
	<div
		class="alert text-center col-5 text-white"
		role="alert"
		style="background-color:#<?php //echo getMoviegoerColorById($current_streak['winner_id']); ?>;">
		<?php //echo "<strong>Current Winning Streak: </strong>" . getMoviegoerById($current_streak['winner_id']) . " with " . $current_streak['count'];
		" wins! "; ?>
	</div>
	<div
		class="alert text-center col-5 text-white"
		role="alert"
		style="background-color:#<?php //echo getMoviegoerColorById($longest_streak_key); ?>;">
		<?php //echo "<strong>Longest Winning Streak: </strong>" . getMoviegoerById($longest_streak_key) . " with " . $longest_streak . " wins! "; ?>
	</div>
</div>

<div class="row mt-3">
	<?php $starting_time = microtime(TRUE); ?>
	<table id="movies" class="table table-striped">
		<thead>
		<tr>
			<th>Name</th>
			<th>Atnd</th>
			<th class="text-end">
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of events a viewer has been to.">
					%
				</div>
			</th>
			<th class="text-end">
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of unique movies a user has put on the wheel.">
					<i class="fas fa-fingerprint"></i> <i class="fas fa-film"></i>
				</div>
			</th>
			<th class="text-end">
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of total movies a user has put on the wheel.">
					<i class="fal fa-ballot-check"></i> <i class="fas fa-film"></i>
				</div>
			</th>
			<th class="text-end">
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="% of Unique movies a user has put on the wheel.">
					<i class="fas fa-fingerprint"></i> %
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of times a viewer's movie has been picked for movie night.">
					<i class="fas fa-trophy"></i>
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The percent of movie nights a viewer has won.">
					<i class="fas fa-trophy"></i> %
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title=" The percentage of attended movie nights that a viewers movie has won.">
					<i class="fas fa-trophy"></i>/Atnd
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="Streak: The most consecutive events that a viewer has had their movie watched, ignoring viewer choice nights.">
					<i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i>
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The longest a viewer has gone without winning (only counting attended events.)">
					<i class="fas fa-cactus"></i>
				</div>
			</th>
			<th aria-sort="ascending">
				Last Spin
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of times a user has spun a wheel or rolled a die.">
					<i class="fas fa-sync"></i>
				</div>
			</th>
			<th class="text-end">
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="The number of minutes viewer has spent watching films.">
					<i class="far fa-stopwatch"></i>
				</div>
			</th>
			<th>
				<div
					data-bs-toggle="tooltip"
					data-bs-animation='false'
					data-bs-placement="right"
					title="Average moving rating across all films viewer placed on wheel.">
					<i class="fas fa-star-half-alt"></i>%
				</div>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php

		$viewer2 = getListOfViewers('attendance');


		foreach ($viewer_stats as $viewer): ?>

			<tr>
				<?php

				$attendance_count = count($viewer['attendance']);
				$unique_count = count($viewer['media']);
				$wedges_count = count($viewer['wedges']);
				$wins_count = count($viewer['wins']);
				$spin_count = count($viewer['spins']);

				$temp_streak_wins = $viewer['streak']['win'];
				$temp_streak_loss = $viewer['streak']['lose'];

				$streak_win_counts = array_map('count', $viewer['streak']['win']);
				$streak_lose_counts = array_map('count', $viewer['streak']['lose']);

				$longest_win_streak = 0;
				$longest_lose_streak = 0;

				foreach ($viewer['streak']['win'] as $win_streak) {
					if (count($win_streak) >= $longest_win_streak) {
						$longest_win_streak = count($win_streak);
					}
				}
				foreach ($viewer['streak']['lose'] as $lose_streak) {
					if (count($lose_streak) >= $longest_lose_streak) {
						$longest_lose_streak = count($lose_streak);
					}
				}


				$average_movie_count = 0;
				$average_movie_total = 0;

				foreach ($viewer['media'] as $media) {
					$average_movie_count++;
					$average_movie_total += $media['item']->reviews->average();
				}

				if ($average_movie_count) {
					$average_movie_rating = round($average_movie_total / $average_movie_count, 2);
				}
				else {
					$average_movie_rating = 0;
				}

				?>
				<td
					style="<?php echo $viewer['item']->css_style_color(); ?>;"
					class="fw-bold"><?php echo $viewer['item']->name; ?></td>
				<td class="text-end"><?php echo $attendance_count; ?></td>
				<td class="text-end"><em><?php echo round(( $attendance_count / $count_events ) * 100, 2) ?>%</em></td>
				<td class="text-end"><?php echo $unique_count; ?></td>
				<td class="text-end"><?php echo $wedges_count; ?></td>
				<td class="text-end"><?php echo ( $wedges_count ) ? round(( $unique_count / $wedges_count ) * 100, 2) : '-'; ?>
					%
				</td>
				<td class="text-end"><?php echo $wins_count; ?></td>
				<td class="text-end"><?php echo ( $count_events ) ? round(( $wins_count / $count_events ) * 100, 2) : '-'; ?>
					%
				</td>
				<td class="text-end"><?php echo ( $attendance_count ) ? round(( $wins_count / $attendance_count ) * 100, 2) : '-'; ?>
					%
				</td>
				<td class="text-end"><?php echo $longest_win_streak; ?></td>
				<td class="text-end"><?php echo $longest_lose_streak; ?></td>
				<td class="text-end"><?php echo ( $spin_count ) ? $viewer['spins'][0]->date->short() : ''; ?></td>
				<td class="text-end"><?php echo $spin_count; ?></td>
				<td class="text-end"><?php echo $viewer['watchtime']; ?></td>
				<td class="text-end"><?php echo $average_movie_rating; ?>%</td>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php $stopping_time = microtime(TRUE);
	echo "Table calculated in " . ( $stopping_time - $starting_time ) . " seconds."; ?>
</div>

<div class="accordion mt-1" id="accordionExample">
	<div class="accordion-item">
		<h2 class="accordion-header" id="headingOne">
			<button
				class="accordion-button collapsed"
				type="button"
				data-bs-toggle="collapse"
				data-bs-target="#collapseOne"
				aria-expanded="false"
				aria-controls="collapseOne">
				*Notes and definitions for above table.
			</button>
		</h2>
		<div
			id="collapseOne"
			class="accordion-collapse collapse "
			aria-labelledby="headingOne"
			data-bs-parent="#accordionExample">
			<div class="accordion-body">
				<ul>
					<li><strong>Name:</strong> Name. Name of viewer.</li>
					<li><strong>Atnd:</strong> Attendance. The number of events a viewer has been to.</li>
					<li><strong>%</strong> Attendance Percentage. The percent of total movie nights a viewer has been in
						attendance.
					</li>
					<li><strong><i class="fas fa-fingerprint"></i></strong> Unique Movies. The number of unique movies a
						user has put on the wheel.
					</li>
					<li><strong><i class="fal fa-ballot-check"></i></strong> Total Movies. The number of total movies a
						user has put on the wheel.
					</li>
					<li><strong><i class="fas fa-fingerprint"></i>%</strong> % of Unique movies a user has put on the
						wheel.
					</li>
					<li><strong><i class="fas fa-trophy"></i></strong> Wins: The number of times a viewer's movie has
						been picked for movie night.
					</li>
					<li><strong><i class="fas fa-trophy"></i> %:</strong> The percent of movie nights a viewer has won.
					</li>
					<li><strong><i class="fas fa-trophy"></i>/Atnd:</strong> The percentage of attended movie nights
						that a viewers movie has won.
					</li>
					<li><strong><i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i></strong> Streak: The most
						consecutive events that a viewer has had their movie watched, ignoring viewer choice nights.
					</li>
					<li><strong><i class="fas fa-cactus"></i></strong> Dry: The longest a viewer has gone without
						winning (only counting attended events.)
					</li>
					<li><strong>Last Spin:</strong> The date if a viewers last spin/roll. Used to determine who is up
						next.
					</li>
					<li><strong><i class="fas fa-sync"></i></strong> Spins: The number of times a user has spun a wheel
						or rolled a die.
					</li>
					<li><strong><i class="far fa-stopwatch"></i></strong> The number of minutes viewer has spent
						watching films.
					</li>
					<li><strong><i class="fas fa-star-half-alt"></i>%</strong> Average Moving Rating across all picked
						films.
					</li>
					<ul>
			</div>
		</div>
	</div>
</div>


<div class="row g-3 mt-5">
	<?php foreach ($viewer2 as $person): ?>

		<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4 mb-4">
			<div class="card">
				<div
					class="card-header fw-bold text-white h3"
					style="background-color:#<?php echo $person['color']; ?>;">
					<?php echo $person['name']; ?>
				</div>

				<ul class="list-group list-group-flush">
					<li class="list-group-item py-3">
						<div class="fw-bold mb-3">Spun Numbers:</div>

						<?php
						$numbers = graphSpunNumbersByViewer($person['id']);
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
								id="column-<?php echo $person['id']; ?>"
								class="charts-css column show-labels show-data-on-hover">
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
										<td style="--size:<?php echo round($value / $max, 2); ?>;">
											<span class="data"><?php echo $value; ?></span></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</li>
					<li class="list-group-item py-3">
						<div class="fw-bold mb-3">Spun People:</div>
						<?php
						$numbers = getSpunViewers_v2($person['id']);

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
								id="column-<?php echo $person['id']; ?>"
								class="charts-css bar show-labels show-data">
								<thead>
								<tr>
									<th scope="col">Number</th>
									<th scope="col">Wins</th>
								</tr>
								</thead>
								<tbody>
								<?php
								foreach ($numbers as $key => $value):?>
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

				<a class="card-footer text-center py-3" href="/viewer/stats?viewer=<?php echo $person['id']; ?>">
					More Stats
				</a>


			</div>
		</div>
	<?php endforeach; ?>


</div>


<script>
	$(document).ready(function () {
		$('#movies').DataTable(
			{
				'searching': false,
				'paging': false,
				'lengthChange': false,
				'order': [[1, 'desc']],
				'columnDefs': [
					{'orderSequence': ['desc', 'asc', 'asc'], 'targets': [11]},
				],
			},
		);
	});

	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});
</script>
</div>
