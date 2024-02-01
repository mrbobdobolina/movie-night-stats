<?php

$event_list = new Event_List();
$event_list->init();
$count_events = count($event_list->events());

$numbers = $numberTypes[rand(0, 3)];

?>
<?php $minutes = calculateTotalWatchtime(); ?>
<p class="display-6 text-center">"Did we really need this?"</p>
<p class="text-center mb-5">"No, but it was fun to make."</p>

<div class="row g-3  mb-3">

	<?php foreach ($event_list->events() as $event): ?>
		<div class="card col-lg-12 p-0">
			<div
				class="card-header pt-2 pb-1 text-white lead"
				style="background-color:#<?php echo $event->winner['viewer']->color; ?>">
				<div class="col-5 float-start">
					<span class="fw-bold">Event <?php echo displayNumbers($count_events--, $numbers); ?></span><br />
					<?php echo $event->date->long(); ?>
				</div>
				<div class="col-5 float-end text-end">
					<i class="fas fa-sync"></i> <?php echo $event->spinner->name; ?><br />
					<i class="fas fa-trophy"></i> <?php echo $event->winner['viewer']->name; ?>
				</div>
			</div>
			<div class="row row-cols-12 row-cols-lg-12 g-1 g-lg-2 px-1">
				<?php for ($i = 1; $i <= 12; $i++): ?>
					<div
						class="col pb-3 pt-3 text-center" <?php if ($event->winning_wedge == $i): ?>
						style="background-color:#<?php echo $event->wedges[$i]['viewer']->color; ?>"
					<?php endif; ?>>
						<?php if ($event->wedges[$i]['media']->id != 0): ?>
							<i
								class="fas fa-film-alt"
								style="color:#<?php echo $event->wedges[$i]['viewer']->color; ?>"></i>

							<img
								src="<?php echo $event->wedges[$i]['media']->poster_url_or_bust(); ?>"
								class="img-fluid poster"
								alt="<?php echo $event->wedges[$i]['media']->name; ?>">
							<?php if ($event->winning_wedge == $i): ?>
								<div class="text-white pt-2">
									<i class="fas fa-sync"></i> by <?php echo $event->spinner->name; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>


	<?php endforeach; ?>


</div>
