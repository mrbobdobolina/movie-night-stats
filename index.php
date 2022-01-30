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



		<div class="row g-3  mb-3">
			<?php foreach($events as $event): ?>
				<?php
				$eventDate = new DateTime($event['date']);
				$winning_wedge = $event['winning_wedge'];
				$winning_moviegoer = $event['moviegoer_'.$winning_wedge];

				//Search OMDB to see if a film poster exists
				$movie_info_url = "http://www.omdbapi.com/?t=".str_replace(" ","+",getMovieById($event['winning_film']))."&apikey=cad1c81e";
				$movie_info = json_decode(file_get_contents($movie_info_url), true);
				?>
				<?php if(count($events) == $count_events && $movie_info['Response'] == "True"):
					//if this is the latest film AND a movie poster exists, show the hero segment. Otherwise, just show a grid.
					//print_r($movie_info);
					?>
					<div class=" col-lg-2">
						<button id="btn-expand-all" class="btn btn-sm btn-outline-primary mb-3 col-8" onclick="$('.collapse').collapse('show'); $('#btn-expand-all').hide(); $('#btn-collapse-all').show();">
							Expand ALL
						</button>
						<button id="btn-collapse-all" class="btn btn-sm btn-outline-primary mb-3 col-8" onclick="$('.collapse').collapse('hide'); $('#btn-expand-all').show(); $('#btn-collapse-all').hide();" style="display:none">
							Collapse ALL
						</button>

						<a href="event_table.php" class="btn btn-sm btn-outline-dark mb-3 col-8">Table View</a>
					</div>


					<div class="card col-lg-8 p-0" >
						<div class="card-header pt-2 pb-1 text-center text-white lead" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
							<h3>Event <?php echo displayNumbers($count_events--, $numbers);?></h3>
							<small><em><?php echo $eventDate->format('l, F j, Y'); ?></em></small>
						</div>
					  <div class="row g-0">
							<div class="col-md-5">
								<div class="card-body text-center justify-content-center">
									<img src="<?php echo $movie_info['Poster']; ?>" class="img-fluid poster" alt="winning movie poster">
								</div>
							</div>
					    <div class="col-md-7">
					      <div class="card-body">
									<table class="table homepage">
										<tbody>
											<?php
											$movie_freshness = Array();
											$movie_years = Array();
											for($i = 1; $i <= 12; $i++):
											?>
												<?php $movie_years[] = get_movie_year($event['wheel_'.$i]); ?>
												<?php if($event['winning_wedge'] == $i): ?>
												<tr class="bold text-white homepage" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
													<td class="number homepage"><?php echo $i; ?></td>
													<td class="viewer-name text-center homepage" ><?php echo getMoviegoerById($event['moviegoer_'.$i]); ?></td>
													<td class="movie-title homepage"><?php echo getMovieById($event['wheel_'.$i]); ?></td>
													<td class="homepage"><?php $movie_freshness[] = getMovieRating($event['wheel_'.$i]);?></td>
												</tr>
												<?php else: ?>
												 <tr class="homepage">
														 <td class="number homepage"><?php echo $i; ?></td>
														 <td class="viewer-name text-center homepage"><?php echo getMoviegoerById($event['moviegoer_'.$i]); ?></td>
														 <td class="movie-title homepage"><?php echo getMovieById($event['wheel_'.$i]); ?></td>
													 	<td class="homepage"><?php $movie_freshness[] = getMovieRating($event['wheel_'.$i]);?></td>
													 </tr>
												<?php endif; ?>
											<?php endfor;?>
										</tbody>
									</table>
								</div>
							</div>

								<p class="text-center">
									<a data-bs-toggle="collapse" href="#collapseExample_<?php echo $count_events; ?>" aria-expanded="false" aria-controls="collapseExample_<?php echo $count_events; ?>">
										More Details...
									</a>
								</p>

								<div class="collapse" id="collapseExample_<?php echo $count_events; ?>">
									<div class="row justify-content-center">
									<div class="card col-6 m-3 p-3">
									<div class="card-body ">
										<?php
										$movie_years = array_filter($movie_years);
										$attendees = explode(",", $event['attendees']);
										$viewers = Array();
										foreach($attendees as $person){
											$viewers[] = getMoviegoerById($person);
										}
										?>
										<ul>
											<li><strong>Attendees:</strong> <?php echo implode(", ", $viewers);?>
											<li><strong>Scribe:</strong> <?php echo getViewerName($event['scribe']); ?></li>
											<li><strong>Spinner:</strong> <?php echo getViewerName($event['spinner']); ?></li>
											<li><strong>Bad Spin #s:</strong> <?php echo $event['error_spin']; ?></li>
											<li><strong>Theme/Comment:</strong> <?php echo $event['theme']; ?></li>
											<li><strong>Movie Format:</strong> <?php echo $event['format']; ?></li>
											<li><strong>Selection Tool:</strong> <?php echo $event['selection_method']; ?></li>
											<li><strong>Runtime:</strong> <?php echo $event['runtime']; ?> minutes</li>
											<li><strong>MPAA:</strong> <?php echo getMovieMPAA($event['winning_film']); ?></li>
											<li><strong>Collective Movie Score:</strong> <?php echo get_freshness($movie_freshness); ?>%</li>
											<li><strong>Winning Movie Score:</strong> <?php echo getMovieRating($event['winning_film']); ?></li>
											<li><strong>Average Movie Year:</strong> <?php echo round(array_sum($movie_years)/count($movie_years)); ?></li>
											<li><strong>Winning Movie Year:</strong> <?php echo get_movie_year($event['winning_film']);?></li>
										</ul>
									</div>
								</div>

							</div>



					      </div>
					    </div>
						</div>
						<div class="row g-3">
				<?php else:?>

				<div class="col col-lg-4 col-md-6, col-sm-12 col-xs-12">
					<div class="card">
						<div class="card-header pt-2 pb-1 text-center text-white lead" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
							<h3>Event <?php echo displayNumbers($count_events--, $numbers);?></h3>
							<small><em><?php echo $eventDate->format('l, F j, Y'); ?></em></small>
						</div>
						
						<div class="card-body">
							<table class="table homepage">
								<tbody>
									<?php
									$movie_freshness = Array();
									$movie_years = Array();
									for($i = 1; $i <= 12; $i++):
									?>
										<?php $movie_years[] = get_movie_year($event['wheel_'.$i]); ?>
										<?php if($event['winning_wedge'] == $i): ?>
										<tr class="bold text-white homepage" style="background-color:#<?php echo getMoviegoerColorById($winning_moviegoer); ?>">
											<td class="number homepage"><?php echo $i; ?></td>
											<td class="viewer-name text-center homepage" ><?php echo getMoviegoerById($event['moviegoer_'.$i]); ?></td>
											<td class="movie-title homepage"><?php echo getMovieById($event['wheel_'.$i]); ?></td>
											<td class="homepage"><?php $movie_freshness[] = getMovieRating($event['wheel_'.$i]);?></td>
										</tr>
										<?php else: ?>
										 <tr class="homepage">
												 <td class="number homepage"><?php echo $i; ?></td>
												 <td class="viewer-name text-center homepage"><?php echo getMoviegoerById($event['moviegoer_'.$i]); ?></td>
												 <td class="movie-title homepage"><?php echo getMovieById($event['wheel_'.$i]); ?></td>
											 	<td class="homepage"><?php $movie_freshness[] = getMovieRating($event['wheel_'.$i]);?></td>
											 </tr>
										<?php endif; ?>
									<?php endfor;?>
								</tbody>
							</table>

							<p class="text-center">
								<a data-bs-toggle="collapse" href="#collapseExample_<?php echo $count_events; ?>" aria-expanded="false" aria-controls="collapseExample_<?php echo $count_events; ?>">
									More Details...
								</a>
							</p>

							<div class="collapse" id="collapseExample_<?php echo $count_events; ?>">
								<div class="card card-body">
									<?php
									$movie_years = array_filter($movie_years);
									$attendees = explode(",", $event['attendees']);
									$viewers = Array();
									foreach($attendees as $person){
										$viewers[] = getMoviegoerById($person);
									}
									?>
									<ul>
										<li><strong>Attendees:</strong> <?php echo implode(", ", $viewers);?>
										<li><strong>Scribe:</strong> <?php echo getViewerName($event['scribe']); ?></li>
										<li><strong>Spinner:</strong> <?php echo getViewerName($event['spinner']); ?></li>
										<li><strong>Bad Spin #s:</strong> <?php echo $event['error_spin']; ?></li>
										<li><strong>Theme/Comment:</strong> <?php echo $event['theme']; ?></li>
										<li><strong>Movie Format:</strong> <?php echo $event['format']; ?></li>
										<li><strong>Selection Tool:</strong> <?php echo $event['selection_method']; ?></li>
										<li><strong>Runtime:</strong> <?php echo $event['runtime']; ?> minutes</li>
										<li><strong>MPAA:</strong> <?php echo getMovieMPAA($event['winning_film']); ?></li>
										<li><strong>Collective Movie Score:</strong> <?php echo get_freshness($movie_freshness); ?>%</li>
										<li><strong>Winning Movie Score:</strong> <?php echo getMovieRating($event['winning_film']); ?></li>
										<li><strong>Average Movie Year:</strong> <?php echo round(array_sum($movie_years)/count($movie_years)); ?></li>
										<li><strong>Winning Movie Year:</strong> <?php echo get_movie_year($event['winning_film']);?></li>
									</ul>
								</div>
							</div>



						</div>
					</div>
				</div>
				<?php endif;?>
			<?php endforeach;?>


		</div>
	</div>
</div>

<?php template('footer'); ?>
