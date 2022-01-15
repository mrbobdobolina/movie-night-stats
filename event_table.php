<?php

require_once('common.php');

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

		<?php //print_r(getMyMovieYears(9));?>

		<div class="row">

			<table id="events" class="table table-hover">
				<thead>
					<tr>
						<td>#</td>
						<td>Date</td>
						<td>Wedge</td>
						<td>Winning Film</td>
						<td>Picker</td>
						<td>Spinner</td>
						<td>Tool</td>
						<td>Format</td>
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
						<td><?php echo $eventDate->format('l, F j, Y'); ?></td>
						<td><?php echo $event['winning_wedge'];?></td>
						<td><?php echo getMovieById($event['winning_film']);?></td>
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
