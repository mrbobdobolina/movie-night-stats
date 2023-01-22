<?php

require_once('../common.php');

template('header');

$events = getListOfEvents("DESC");
$count_events = count($events);
$numbers = $numberTypes[rand(0,3)];

?>
<div class="album py-5 bg-light">
	<div class="container">
		<?php $minutes = calculateTotalWatchtime(); ?>
		<p class="display-6 text-center">(╯°□°）╯︵ ┻━┻</p>
		<p class="text-center mb-5"><em>"My how the events have tabled."</em></p>

		<div class="row">

			<table id="events" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Wedge</th>
						<th>Winning Film</th>
						<th>Winner</th>
						<th>Spinner</th>
						<th>Tool</th>
						<th>Format</th>
					</tr>
				</thead>

				<?php foreach($events as $event): ?>

					<?php
					//print_r($event);
					$eventDate = new DateTime($event['date']);
					$winning_wedge = $event['winning_wedge'];
					$winning_moviegoer = $event['moviegoer_'.$winning_wedge];
					?>
					<tr class="text-white" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
						<td><?php echo $count_events--;?></td>
						<td><?php echo $eventDate->format('l, M j, Y'); ?></td>
						<td><?php echo $event['winning_wedge'];?></td>
						<td><?php echo get_movie_by_id($pdo,$event['winning_film']);?></td>
						<td><?php echo getMoviegoerById($event['winning_moviegoer']);?></td>
						<td><?php echo getMoviegoerById($event['spinner']);?></td>
						<td><?php echo $event['selection_method'];?></td>
						<td><?php echo $event['format'];?></td>
					</tr>
				<?php endforeach; ?>
				</table>





		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
			$('#events').DataTable(
				{
					"pageLength": 100,
					 "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
					"order": [[ 0, "desc" ]]
				}
			);
	} );
	</script>

<?php template('footer'); ?>
