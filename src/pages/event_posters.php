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
		<p class="display-6 text-center">Running out of wall space</p>
		<p class="text-center mb-5"><em>...and also printer ink.</em></p>

		<div class="row g-3">
			<?php foreach($events as $event): ?>
				<?php
				$eventDate = new DateTime($event['date']);
				$winning_wedge = $event['winning_wedge'];
				$winning_moviegoer = $event['moviegoer_'.$winning_wedge];
				?>
					<div class="col col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<div class="card" >
						<div class="card-header pt-2 pb-1 text-center text-white lead" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
							<h3>Event <?php echo displayNumbers($count_events--, $numbers);?></h3>
							<small><em><?php echo $eventDate->format('l, F j, Y'); ?></em></small>
						</div>
					  <div class="row g-0">
							<div class="col-md-12">
								<div class="card-body text-center justify-content-center">
									<img src="<?php echo get_movie_poster($pdo, $event['winning_film']); ?>" class="img-fluid poster" alt="winning movie poster">
								</div>
							</div>

					      </div>
					    </div>
</div>


			<?php endforeach;?>


		</div>
	</div>
</div>

<?php template('footer'); ?>
