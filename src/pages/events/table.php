<div class="container my-4 mns-events mns-view-win-table">
	<?php

	$event_list = new Event_List();
	$event_list->init();

	$count_events = count($event_list->events());
	/** @var array $numberTypes */
	$numbers = $numberTypes[rand(0, 3)];

	?>
	<h1 class="text-center">Wins - Table View</h1>
	<p class="text-center mb-4">My how the turntables. (╯°□°）╯︵ ┻━┻</p>


	<table id="events" class="table table-hover bg-clear">
		<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Winning Film</th>
			<th>Winner</th>
			<th>Spinner</th>
			<th>Tool</th>
			<th>Format</th>
		</tr>
		</thead>
		<tbody>
		<?php
		/** @var Event_Item $event */
		foreach ($event_list->events() as $event): ?>

			<tr style="<?php echo $event->winner['viewer']->css_style_color(); ?>">
				<td><?php echo $count_events--; ?></td>
				<td><?php echo $event->date->long(); ?></td>
				<td><?php echo $event->winner['media']->name; ?></td>
				<td><?php echo $event->winner['viewer']->name; ?></td>
				<td><?php echo $event->spinner->name; ?></td>
				<td><?php echo $event->selection_method->name; ?></td>
				<td><?php echo $event->format->name; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>


	<script>
		$(document).ready(function () {
			$('#events').DataTable(
				{
					'pageLength': 100,
					'lengthMenu': [[50, 100, 200, -1], [50, 100, 200, 'All']],
					'order': [[0, 'desc']],
				},
			);
		});
	</script>

</div>
