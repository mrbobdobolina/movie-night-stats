<div class="container my-4 mns-events mns-view-poster-win">
	<?php

	$event_list = new Event_List();
	$event_list->init();
	$count_events = count($event_list->events());

	?>
	<?php $minutes = calculateTotalWatchtime(); ?>
	<h1 class="text-center">Events - Winning Poster View</h1>
	<p class="text-center mb-4"><em>Running out of wall space...and also printer ink.</em></p>

	<div class="row g-3">
		<?php foreach ($event_list->events() as $event): ?>
			<div class="col-12 col-md-6 col-lg-3">
				<div class="card">
					<div
						class="card-header"
						style="<?php echo $event->winner['viewer']->css_style_color(); ?>">
						<div class="event-number">
							Event
							<span data-mns-number="<?php echo $count_events; ?>">
								<?php echo $count_events--; ?>
							</span>
						</div>
						<div class="event-date">
							<?php echo $event->date->long(); ?>
						</div>
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
