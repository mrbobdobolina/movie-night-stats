<?php

$viewer_list = new Viewer_List();
$viewer_list->init();

$event_list = new Event_List($viewer_list);
$event_list->init();
$count_events = count($event_list->events());


function stats_by_movie($events): array {
	$movie_stats = [];

	foreach($events as $event){
		$already_counted_win = false;
		$already_counted_media = [];

		foreach($event->wedges as $wedge){
			if($wedge['media']->id) {
				$this_id = $wedge['media']->id;

				if (!array_key_exists($this_id, $movie_stats)) {
					$movie_stats[$this_id] = [
						'item' => $wedge['media'],
						'wins' => [],
						'formats' => [],
						'wedges' => 0,
						'events' => 0,
						'dates' => [],
						'pickers' => []
					];
				}

				$movie_stats[$this_id]['dates'][] = $event->date;
				$movie_stats[$this_id]['wedges']++;

				if (!in_array($this_id, $already_counted_media)) {
					$movie_stats[$this_id]['events']++;
					$already_counted_media[] = $this_id;
				}

				if (!$already_counted_win && $event->winner['media']->id == $this_id) {
					$movie_stats[$this_id]['wins'][] = $event->date;
					$movie_stats[$this_id]['formats'][] = $event->format->name;
					$already_counted_win = true;
				}

				if(!array_key_exists($wedge['viewer']->id, $movie_stats[$this_id]['pickers'])){
					$movie_stats[$this_id]['pickers'][$wedge['viewer']->id] = [
						'item' => $wedge['viewer'],
						'count' => 0
					];
				}
				$movie_stats[$this_id]['pickers'][$wedge['viewer']->id]['count']++;
			}

		}
	}

	return $movie_stats;
}


$movie_stats = stats_by_movie($event_list->events);

function winning_film_count($movie_stats): int {
	$count = 0;
	foreach($movie_stats as $stat){
		if(count($stat['wins'])){
			$count++;
		}
	}
	return $count;
}

?>
<p class="display-6 text-center "><?php echo count($movie_stats);?> Films We Could Have Watched</p>
<p class="lead text-center ">(And the <?php echo winning_film_count($movie_stats); ?> we did.)</p>

<div class="row">
	<p>
		<i class="fas fa-star p-1" style="color:#FFFF00;background-color:#82D173;"></i> Indicates movie was (randomly) spun its first night on the wheel. <i class="fas fa-hand-point-down p-1" style="color:#FFFF00;background-color:#82D173;"></i> Indicated movie was picked (viewer choice) its first night on the wheel. <span style="background-color:#82D173;">Green row indicates movie won at least once.</span>
	</p>

	<table id="movies" class="table table-striped">
		<thead>
			<tr>
				<th><i class="fas fa-star"></i></th>
				<th class="col-2">Title</th>
				<th class="text-center"><i class="fa-regular fa-photo-film-music"></i></th>
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
			$oneHitWonders = 0;

			$counter = 0;

			foreach($movie_stats as $movie):
				$counter++;

				if($movie['wins']){
					echo '<tr style="background-color:#82D173;">';
				}
				else {
					echo '<tr>';
				}
				
				if(count($movie['wins'])){
					$media_first_win = $movie['wins'][count($movie['wins']) - 1];
					$media_first_date = $movie['dates'][count($movie['dates']) - 1];
					$media_first_format = $movie['formats'][count($movie['formats']) - 1];
					
					if($media_first_win->short() == $media_first_date->short()){
						if($media_first_format != 'viewer choice'){
							$oneHitWonders++;
							echo '<td data-search="one hit wonder" data-order="2"><i class="fas fa-star" style="color:#FFFF00;"></i>';
						} else {
							echo '<td data-search="picked first night" data-order="1"><i class="fas fa-hand-point-down" style="color:#FFFF00;">';
						}
					} else {
						echo '<td data-search="" data-order="0">';
					}
				}
				else {
					echo '<td data-search="" data-order="0">';
				}

				echo '</td>';

				?>
					<td><?php echo $movie['item']->name; ?> </td>
					<?php $type_data = Array("" => "", "film" => "film movie", "tv" => "tv show episode series", "gamepad" => "video game", "twitch" => "twitch"); ?>
					<td data-search="<?php echo $type_data[$movie['item']->type];?>" data-order="<?php echo $movie['item']->type;?>" class="text-center"><i class="fa fa-<?php echo $movie['item']->type;?>"></td>
					<td class="text-center"><?php echo $movie['item']->year; ?></td>
					<td class="text-end mpaa"><?php echo $movie['item']->mpaa; ?></td>
					<td class="text-end"><?php echo $movie['item']->runtime; ?></td>
					<td class="text-end"><?php echo $movie['item']->reviews->average(); ?>%</td>
					<td class="text-center"><?php echo count($movie['wins']); ?></td>
					<td class="text-center"><?php echo $movie['wedges']; ?></td>
					<td class="text-center"><?php echo $movie['events']; ?></td>
					<td><?php echo $movie['dates'][count($movie['dates'])-1]->short(); ?></td>
					<td><?php echo $movie['dates'][0]->short();?></td>
					<td>
						<?php
						$pickerArray = Array();
						foreach($movie['pickers'] as $viewer){
							$pickerArray[] = $viewer['item']->name . " (".$viewer['count'].")";
						}
						echo implode(", ", $pickerArray);
						?>
					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="row justify-content-around">
		<div class="alert alert-warning text-center col-5">
			<p>	We've had a total of <?php echo $oneHitWonders; ?> "One Hit Wonders". <br />(Movies picked randomly on their first apperance on the wheel.)</p>
		</div>
	</div>



</div>

<script>
$(function() {
	$('#movies').DataTable(
		{
			"pageLength": 100,
			"lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
			"order": [[ 1, "asc" ]]
		}
	);
} );

</script>

