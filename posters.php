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
		<p class="display-6 text-center">"I'm not a nerd, you're a nerd."</p>
		<p class="text-center mb-5">Over <?php echo number_format($minutes); ?> minutes of "entertainment." (Or <?php echo round(($minutes/60), 2);?> hours.) (Or <?php echo round(($minutes/60)/24, 2);?> days.)</p>

		<button id="btn-expand-all" class="btn btn-outline-primary mb-3" onclick="$('.collapse').collapse('show'); $('#btn-expand-all').hide(); $('#btn-collapse-all').show();">
			Expand ALL
		</button>
		<button id="btn-collapse-all" class="btn btn-outline-primary mb-3" onclick="$('.collapse').collapse('hide'); $('#btn-expand-all').show(); $('#btn-collapse-all').hide();" style="display:none">
			Collapse ALL
		</button>

		<a href="event_table.php" class="btn btn-outline-dark mb-3 mx-2">Table View</a>

		<div class="row g-3">
			<?php foreach($events as $event): ?>
				<?php
				$eventDate = new DateTime($event['date']);
				$winning_wedge = $event['winning_wedge'];
				$winning_moviegoer = $event['moviegoer_'.$winning_wedge];

				//Search OMDB to see if a film poster exists
				$movie_info_url = "http://www.omdbapi.com/?t=".str_replace(" ","+",getMovieById($event['winning_film']))."&apikey=cad1c81e";
				$movie_info = json_decode(file_get_contents($movie_info_url), true);
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
									<?php if($movie_info['Response'] == "True"):?>
										<img src="<?php echo $movie_info['Poster']; ?>" class="img-fluid poster" alt="winning movie poster">
									<?php else: ?>
										<img src="https://via.placeholder.com/400x600/<?php echo getMoviegoerColorById($winning_moviegoer); ?>/fff?text=<?php echo str_replace(" ","+",getMovieById($event['winning_film']));?>" class="img-fluid poster" alt="winning movie poster">
									<?php endif; ?>
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
