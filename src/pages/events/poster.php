<div class="container my-4 mns-events mns-view-poster">
	<?php

	$event_list = new Event_List();
	$event_list->init();
	$count_events = count($event_list->events());

	?>
	<?php $minutes = calculateTotalWatchtime(); ?>
	<h1 class="text-center">Events - Poster View</h1>
	<p class="text-center mb-4">Did we really need this? No, but it was fun to make.</p>

	<div class="row g-3">

		<?php foreach ($event_list->events() as $event): ?>
			<div class="col-12">
				<div class="card shadow">

					<div class="card-header" style="<?php echo $event->winner['viewer']->css_style_color(); ?>">
						<div class="row">
							<div class="col">
								<div class="event-number">
									Event
								</div>
								<div class="event-date">
									<?php echo $event->date->long(); ?>
								</div>
							</div>
							<div class="col event-info">
								<i class="fas fa-sync"></i> <?php echo $event->spinner->name; ?><br />
								<i class="fas fa-trophy"></i> <?php echo $event->winner['viewer']->name; ?>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row g-1">
							<?php for ($i = 1; $i <= 12; $i++): ?>
								<div
									class="col-6 col-sm-2 col-lg-1 text-center"
									<?php if ($event->winning_wedge == $i): ?>
										style="<?php echo $event->wedges[$i]['viewer']->css_style_color(); ?>"
									<?php endif; ?>>
									<?php if ($event->wedges[$i]['media']->id != 0): ?>
										<?php echo $event->wedges[$i]['viewer']->name; ?>

										<img
											src="<?php echo $event->wedges[$i]['media']->poster_url_or_bust(); ?>"
											class="poster"
											alt="<?php echo $event->wedges[$i]['media']->name; ?>">
										<?php if ($event->winning_wedge == $i): ?>
											<div class="my-2">
												<i class="fas fa-trophy"></i>
											</div>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</div>

		<?php endforeach; ?>


	</div>
</div>
