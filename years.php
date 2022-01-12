<?php

require_once('common.php');

template('header');

?>


<div class="album py-5 bg-light">
	<div class="container">

		<p class="display-6 text-center mb-5">Our long and storied history.</p>
		<p class="text-center mb-5"></p>
		<?php

		$yearly_events = Array();
		$yearly_time = Array();
		$yearly_attendance = Array();
		$current_year = date('Y');
		for($y = 2019; $y <= $current_year; $y++){
			$yearly_events[$y] = count_yearly_events($y);
			$yearly_time[$y] = calculateYearlyWatchtime($y);
			$yearly_attendance[$y] = calculate_attendance($y);
		}
		$max_events = max($yearly_events);
		$max_time = max($yearly_time);
		$max_attendance = max($yearly_attendance);

		?>
		<div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">

			<div class="col">
				<div class="card ">
					<div class="card-body">
						<p>Movie events held by year.</p>
						<table id="column-years" class="charts-css column show-labels show-data">
							<thead>
								<tr>
									<th scope="col">Years</th>
									<th scope="col">Movies</th>
								</tr>
							</thead>
								<tbody style="height: 250px;">
									<?php foreach($yearly_events as $key => $value):?>
									<tr>
										<th scope="row"><?php echo $key; ?> </th>
										<td style="--size:<?php echo round($value/$max_events,2); ?>;"><span class="data"><?php echo $value; ?></span></td>
									</tr>
								<?php endforeach;?>
								</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card ">
					<div class="card-body">
						<p>Minutes watched by year.</p>
						<table id="column-years" class="charts-css column show-labels show-data">
							<thead>
								<tr>
									<th scope="col">Years</th>
									<th scope="col">Minutes</th>
								</tr>
							</thead>
								<tbody style="height: 250px;">
									<?php foreach($yearly_time as $key => $value):?>
									<tr>
										<th scope="row"><?php echo $key; ?> </th>
										<td style="--size:<?php echo round($value/$max_time,2); ?>;"><span class="data"><?php echo $value; ?></span></td>
									</tr>
								<?php endforeach;?>
								</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card ">
					<div class="card-body">
						<p>Attendance by year.</p>
						<table id="column-years" class="charts-css column show-labels show-data">
							<thead>
								<tr>
									<th scope="col">Years</th>
									<th scope="col">Minutes</th>
								</tr>
							</thead>
								<tbody style="height: 250px;">
									<?php foreach($yearly_attendance as $key => $value):?>
									<tr>
										<th scope="row"><?php echo $key; ?> </th>
										<td style="--size:<?php echo round($value/$max_attendance,2); ?>;"><span class="data"><?php echo $value; ?></span></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


		</div>


		<?php for($ii = $current_year; $ii >= 2019; $ii--):?>
			<div class="card p-2 mt-5 mb-3">
				<p class="display-6 text-center mt-5 mb-2"> <?php echo $ii; ?> Stats</p>


				<div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3 justify-content-center">

					<div class="col align-self-center">
						<?php

						$biggest_winner = biggest_winner($ii);
						$winners = count($biggest_winner['top_winners']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest_winner['top_winners'] as $person){
								$people[] = getMoviegoerById($person);
							}

							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest_winner['count']." wins!";
							$color = getMoviegoerColorById($biggest_winner['top_winners'][0]);
						}
						elseif($winners == 1) {
							$message = getMoviegoerById($biggest_winner['top_winners'][0]) ." with ". $biggest_winner['count']." wins!";
							$color = getMoviegoerColorById($biggest_winner['top_winners'][0]);
						}
						else {
							$message = "(no wins yet)";
							$color = "999999";
						}

						?>
						<div class="card " style="background-color:#<?php echo $color; ?>;">
							<div class="card-body text-white">
								<p class="bold">Most Wins:</p>
								<p class="display-6 text-center message">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest_spinner = biggest_spinner($ii);
						$winners = count($biggest_spinner['top_spinner']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest_spinner['top_spinner'] as $person){
								$people[] = getMoviegoerById($person);
							}

							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest_spinner['count']." spins!";
							$color = getMoviegoerColorById($biggest_spinner['top_spinner'][0]);
						}
						elseif($winners == 1) {
							$message = getMoviegoerById($biggest_spinner['top_spinner'][0]) ." with ". $biggest_spinner['count']." spins!";
							$color = getMoviegoerColorById($biggest_spinner['top_spinner'][0]);
						}
						else {
							$message = "(no spins yet)";
							$color = "999999";
						}

						?>
						<div class="card " style="background-color:#<?php echo $color; ?>;">
							<div class="card-body text-white">
								<p class="bold">Most Spins:</p>
								<p class="display-6 text-center">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest = highest_attendance($ii);
						$winners = count($biggest['top']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest['top'] as $person){
								$people[] = getMoviegoerById($person);
							}
							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest['count']." events!";
							$color = getMoviegoerColorById($biggest['top'][0]);
						}
						elseif($winners == 1) {
							$message = getMoviegoerById($biggest['top'][0]) ." with ". $biggest['count']." events!";
							$color = getMoviegoerColorById($biggest['top'][0]);
						}
						else {
							$message = "(no events yet)";
							$color = "999999";
						}

						?>
						<div class="card " style="background-color:#<?php echo $color; ?>;">
							<div class="card-body text-white">
								<p class="bold">Top Attendance:</p>
								<p class="display-6 text-center">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest = biggest_blank($ii, 'selection_method');
						$winners = count($biggest['top']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest['top'] as $person){
								$people[] = $person;
							}

							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest['count']." events!";
						}
						elseif($winners == 1) {
							$message = $biggest['top'][0] ." with ". $biggest['count']." events!";
						}
						else {
							$message = "(no events yet)";
						}

						?>
						<div class="card ">
							<div class="card-body">
								<p class="bold">Top Selection Method:</p>
								<p class="display-6 text-center">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest = biggest_blank($ii, 'winning_wedge', TRUE);
						$winners = count($biggest['top']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest['top'] as $person){
								$people[] = $person;
							}
							$message = "It's a ".$winners."-way tie between #s".implode(' and ', $people)." with ". $biggest['count']." events!";
						}
						elseif($winners == 1) {
							$message = "#".$biggest['top'][0] ." with ". $biggest['count']." events!";
						}
						else {
							$message = "(no events yet)";
						}

						?>
						<div class="card align-self-center">
							<div class="card-body">
								<p class="bold">Most Spun Number:</p>
								<p class="display-6 text-center">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest = biggest_blank($ii, 'format');
						$winners = count($biggest['top']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest['top'] as $person){
								$people[] = $person;
							}
							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest['count']." events!";
							$color = get_service_color($biggest['top'][0]);
						}
						elseif($winners == 1) {
							$message = $biggest['top'][0] ." with ". $biggest['count']." events!";
							$color = get_service_color($biggest['top'][0]);
						}
						else {
							$message = "(no events yet)";
							$color = "999999";
						}

						?>
						<div class="card " style="background-color:<?php echo $color; ?>;">
							<div class="card-body text-white">
								<p class="bold">Top Service:</p>
								<p class="display-6 text-center">
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$biggest = most_requested_film($ii);
						$winners = count($biggest['top']);
						if($winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							foreach($biggest['top'] as $person){
								$people[] = getMovieById($person);
							}
							$message = "It's a ".$winners."-way tie between ".implode(' and ', $people)." with ". $biggest['count']." requests!";
						} elseif($winners == 1) {
							$message = getMovieById($biggest['top'][0]) ." with ". $biggest['count']." requests!";
						} else {
							$message = "(no requests yet)";
						}

						?>
						<div class="card align-self-center">
							<div class="card-body" >
								<p class="bold">Most Requested Films:</p>
								<p class="display-6 text-center" >
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<div class="col align-self-center">
						<?php

						$won_films = find_best_or_worst_watched_film_with_year_option($best_or_worst = "best", $year = $ii);
						unset($winners);
						$top_rating = $won_films[0]['avg_rating'];
						foreach($won_films as $aFilm ){
							if($aFilm['avg_rating'] == $top_rating){
								$winners[] = $aFilm;
							} else {
								break;
							}
						}

						unset($names);
						$names = Array();
						foreach($winners as $film){
							if(!in_array($film['name'], $names)){
								$names[] = $film['name'];
							}
						}

						$count_winners = count($names);
						if($count_winners > 1){
							//more than one person one! It's a tie!
							$people = Array();

							$message = "It's a ".$count_winners."-way tie between ".implode(' and ', $names)." with ". round($top_rating,2)."% average rating!";
						}
						elseif($count_winners == 1) {
							$message = $winners[0]['name'] ." with ". round($top_rating,1)."% average rating!";
						}
						else {
							$message = "(no films yet)";
						}

						?>
						<div class="card align-self-center">
							<div class="card-body" >
								<p class="bold">Highest Rated Watched Film:</p>
								<p class="display-6 text-center" >
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>


					<div class="col align-self-center">
						<?php

						$won_films = find_best_or_worst_watched_film_with_year_option($best_or_worst = "worst", $year = $ii);
						unset($winners);
						$top_rating = $won_films[0]['avg_rating'];
						foreach($won_films as $aFilm ){
							if($aFilm['avg_rating'] == $top_rating){
								$winners[] = $aFilm;
							} else {
								break;
							}
						}

						unset($names);
						$names = Array();
						foreach($winners as $film){
							if(!in_array($film['name'], $names)){
								$names[] = $film['name'];
							}
						}

						$count_winners = count($names);
						if($count_winners > 1){
							//more than one person one! It's a tie!
							$people = Array();
							$message = "It's a ".$count_winners."-way tie between ".implode(' and ', $names)." with ". round($top_rating,2)."% average rating!";
						}
						elseif($count_winners == 1) {
							$message = $winners[0]['name'] ." with ". round($top_rating,1)."% average rating!";
						}
						else {
							$message = "(no films yet)";
						}

						?>
						<div class="card align-self-center">
							<div class="card-body" >
								<p class="bold">Worst Rated Watched Film:</p>
								<p class="display-6 text-center" >
									<?php echo $message;?>
								</p>
							</div>
						</div>
					</div>

					<?php

					unset($format_m);
					unset($count_m);
					unset($color_m);

					$colors = get_service_color();

					$minutes_watched = count_minutes_per_service($ii);
					//print_r($minutes_watched);
					foreach($minutes_watched as $item){
						$format_m[] = $item['format'];
						$count_m[] = $item['SUM(`runtime`)'];

						$color_m[] = $colors[$item['format']];

					}

					?>
					<canvas id="myTimeChart<?php echo $ii;?>" width="400" height="150" style="position:relative; !important"></canvas>

					<script>
					var ctx = document.getElementById('myTimeChart<?php echo $ii;?>').getContext('2d');
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
		<?php endfor;?>

	</div>
</div>


<?php template('footer');?>
