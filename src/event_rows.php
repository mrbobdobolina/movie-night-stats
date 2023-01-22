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
		<p class="display-6 text-center">"Did we really need this?"</p>
		<p class="text-center mb-5">"No, but it was fun to make."</p>

		<div class="row g-3  mb-3">

			<?php foreach($events as $event): ?>
				<?php
				$eventDate = new DateTime($event['date']);
				$winning_wedge = $event['winning_wedge'];
				$winning_moviegoer = $event['moviegoer_'.$winning_wedge];
				?>

					<div class="card col-lg-12 p-0" >
						<div class="card-header pt-2 pb-1 text-white lead" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
							<div class="col-5 float-start">
								<span class="fw-bold">Event <?php echo displayNumbers($count_events--, $numbers);?></span><br />
								<?php echo $eventDate->format('l, F j, Y'); ?>
							</div>
							<div class="col-5 float-end text-end">
								<i class="fas fa-sync"></i> <?php echo getMoviegoerById($event['spinner']); ?><br />
								<i class="fas fa-trophy"></i> <?php echo getMoviegoerById($event['winning_moviegoer']); ?>
							</div>
						</div>
					  <div class="row row-cols-12 row-cols-lg-12 g-1 g-lg-2 px-1">
								<?php for($i = 1; $i <= 12; $i++):?>
									<div class="col pb-3 pt-3 text-center" <?php if($event['winning_wedge'] == $i): ?>
										style="background-color:#<?php echo getMoviegoerColorById($event['winning_moviegoer']); ?>"
									<?php endif; ?>>
									<?php if($event['wheel_'.$i] != 0): ?>
										<i class="fas fa-film-alt" style="color:#<?php echo getMoviegoerColorById($event['moviegoer_'.$i]); ?>"></i>

										<img src="<?php echo get_movie_poster_v3($pdo, $event['wheel_'.$i]); ?>" class="img-fluid poster" alt="<?php echo get_movie_by_id($pdo,$event['wheel_'.$i]); ?>">
										<?php if($event['winning_wedge'] == $i): ?>
											<div class="text-white pt-2">
												<i class="fas fa-sync"></i> by <?php echo getMoviegoerById($event['spinner']); ?>
											</div>
										<?php endif; ?>
										<?php endif; ?>
									</div>
								<?php endfor; ?>
						</div>
 					</div>


			<?php endforeach;?>


		</div>
	</div>
</div>

<?php template('footer'); ?>
