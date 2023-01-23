<?php

require_once('../common.php');

template('header');

$movie_count = count_movie_list($pdo);

?>
<script>
	var nanobar = new Nanobar();
	nanobar.go(0);
</script>
<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center "><?php echo $movie_count;?> Films We Could Have Watched</p>
		<p class="lead text-center ">(And the <?php echo countWatchedMovies();?> we did.)</p>

		<div class="row">
			<p>
				<i class="fas fa-star p-1" style="color:#FFFF00;background-color:#82D173;"></i> Indicates movie was (randomly) spun its first night on the wheel. <i class="fas fa-hand-point-down p-1" style="color:#FFFF00;background-color:#82D173;"></i> Indicated movie was picked (viewer choice) its first night on the wheel. <span style="background-color:#82D173;">Green row indicates movie won at least once.</span>
			</p>

			<table id="movies" class="table table-striped">
				<thead>
					<tr>
						<th><i class="fas fa-star"></i></th>
						<th class="col-2">Title</th>
						<th>Year</th>
						<th class="text-end">MPAA#</th>
						<th class="text-end">Runtime</th>
						<th class="text-end"><i class="far fa-frown"></i><i class="far fa-meh"></i><i class="far fa-smile"></i></th>
						<th><i class="fas fa-trophy"></i></th>
						<th><i class="far fa-cheese"></i></th>
						<!-- <th>% of Wedges</th> -->
						<th><i class="fas fa-house-night"></i></th>
						<!-- <th>% of Nights</th>-->
						<th>First Date</th>
						<th>Last Date</th>
						<th class="col-2">Pickers</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$movies = get_movie_list($pdo);
					$week_count = countWeeks();
					$total_wedges = countWeeks()*12;
					$oneHitWonders = 0;

					$counter = 0;

					foreach($movies as $movie):
						$counter++;
						$winner = didIWin($movie['id']);
						//$first_date = getFirstOrLastDate($movie['id'], "First");

						$wedges = count_total_film_appearances($pdo, $movie['id']);
						$weeks = countWeeksOnWheel($movie['id']);

						if($winner['count'] > 0){
							echo '<tr style="background-color:#82D173;">';
						}
						else {
							echo '<tr>';
						}

						?>


								<?php
								if($winner['first_win'] == $movie['first_instance']){
									if(!was_it_viewer_choice($movie['first_instance'],$movie['id'])){
										$oneHitWonders++;
										echo '<td data-search="one hit wonder" data-order="2"><i class="fas fa-star" style="color:#FFFF00;"></i>';
									} else {
										echo '<td data-search="picked first night" data-order="1"><i class="fas fa-hand-point-down" style="color:#FFFF00;">';
									}
								} else {
									echo '<td data-search="" data-order="0">';
								}?>
							</td>
							<td><?php echo $movie['name']; ?> </td>
							<td class="text-center"><?php echo $movie['year']; ?></td>
							<td class="text-end mpaa"><?php echo $movie['MPAA']; ?></td>
							<td class="text-end"><?php echo $movie['runtime']; ?></td>
							<td class="text-end"><?php echo get_movie_avg_rating($pdo,$movie['id']); ?></td>
							<td class="text-center"><?php echo $winner['count']; ?></td>
							<td class="text-center"><?php echo $wedges; ?></td>
							<!-- <td class="text-end"><?php //echo round(($wedges/$total_wedges)*100,2);?>%</td>-->
							<td class="text-center"><?php echo $weeks; ?></td>
							<!-- <td class="text-end"><?php //echo round(($weeks/$week_count)*100,2);?>%</td>-->
							<td><?php echo $movie['first_instance']; ?></td>
							<td><?php echo $movie['last_instance'];?></td>
							<td>
								<?php
								$pickers = getPickers_v3($movie['id']);
								//print_r($pickers);
								$pickerArray = Array();
								foreach($pickers as $viewer => $count){
									$pickerArray[] = getViewerName($viewer) . " (".$count.")";
								}
								echo implode(", ", $pickerArray);
								?>
							</td>

						</tr>

						<script>
							nanobar.go(<?php echo floor(($counter/$movie_count)*100)-1; ?>);
						</script>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="row justify-content-around">
				<div class="alert alert-warning text-center col-5">
					<p>	We've had a total of <?php echo $oneHitWonders; ?> "One Hit Wonders". <br />(Movies picked randomly on their first apperance on the wheel.)</p>
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
					"order": [[ 1, "asc" ]]
				}
			);
	} );

	nanobar.go(100);
	</script>

<?php template('footer');?>
