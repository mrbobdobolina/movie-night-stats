<div class="container">
	<?php


	$event_list = new Event_List();
	$event_list->init();
	$count_events = count($event_list->events());

	$numbers = $numberTypes[rand(0, 3)];

	?>
	<?php $minutes = calculateTotalWatchtime(); ?>
	<p class="display-6 text-center">Running out of wall space</p>
	<p class="text-center mb-5"><em>...and also printer ink.</em></p>

	<div class="row g-3">
		<?php foreach ($event_list->events() as $event): ?>
			<div class="col-12 col-md-6 col-lg-3">
				<div class="card">
					<div
						class="card-header pt-2 pb-1 text-center text-white lead"
						style="background-color:#<?php echo $event->winner['viewer']->color; ?>">
						<h3>Event <?php echo displayNumbers($count_events--, $numbers); ?></h3>
						<small><em><?php echo $event->date->long(); ?></em></small>
					</div>
					<div class="row g-0">
						<div class="col-md-12">
							<div class="card-body text-center justify-content-center">
								<img
									src="<?php echo $event->winner['media']->poster_url_or_bust(); ?>"
									class="img-fluid poster"
									alt="winning movie poster">
							</div>
						</div>
					</div>
				</div>
			</div>


		<?php endforeach; ?>


	</div>
</div>
