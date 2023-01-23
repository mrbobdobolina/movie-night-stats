<?php

require_once('../common.php');

include(ROOT.'inc/Event_List.php');

template('header');

$event_list = getListOfEvents("DESC");
$event_list = new Event_List();
$event_list->init();
$count_events = count($event_list->events());
$numbers = $numberTypes[rand(0,3)];

?>
<script>
	let nanobar = new Nanobar();
	nanobar.go(5);
</script>
<div class="py-5 bg-light">
	<div class="container">
		
		
		
		<p class="display-6 text-center">"I'm not a nerd, you're a nerd."</p>
		<p class="text-center mb-5">
			<?php
			$minutes = $event_list->sum_watchtime();
			echo 'Over '.number_format($minutes).' minutes of "entertainment." ';
			echo '(Or '.round(($minutes/60), 2).' hours.) ';
			echo '(Or '.round(($minutes/60)/24, 2).' days.)';
			?>
		</p>



		<div class="row justify-content-center">
			<div class=" col-lg-2">
				<button id="btn-expand-all" class="btn btn-sm btn-outline-primary mb-3 col-8" onclick="$('.collapse').collapse('show'); $('#btn-expand-all').hide(); $('#btn-collapse-all').show();">
					<i class="fa-solid fa-angles-down"></i> Expand ALL
				</button>
				<button id="btn-collapse-all" class="btn btn-sm btn-outline-primary mb-3 col-8" onclick="$('.collapse').collapse('hide'); $('#btn-expand-all').show(); $('#btn-collapse-all').hide();" style="display:none">
					<i class="fa-solid fa-angles-up"></i> Collapse ALL
				</button>

				<a href="event_table.php" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-table"></i> Table View</a>
				<a href="event_rows.php" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-images"></i> Poster View</a>
				<a href="event_posters.php" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-image-portrait"></i> Winning Poster</a>
			</div>
			<?php
			
			$i = 0;
			
			foreach($event_list->events() as $event): 
				$i++;
				?>
				<script>nanobar.go(<?php echo floor(($i/$count_events)*100)-1;?>);</script>
					
				<div class="mb-3 col-12 <?php if($i == 1) {echo 'col-md-8';} else {echo 'col-md-6 col-lg-4';} ?>">
					<div class="card">

						<!-- Card Header -->
						<div class="card-header pt-2 pb-1 text-center text-white lead" style="background-color:#<?php echo $event->winner_viewer->color; ?>">
							<h3>Event <?php echo displayNumbers($count_events--, $numbers);?></h3>
							<small><em><?php echo $event->date->long(); ?></em></small>
						</div>

						<!-- Card Body -->
						<div class="card-body">
							<div class="row">
								<?php
								
								if($i == 1){
									?>
									<div class="col">
										<div class="card-body text-center justify-content-center">
											<img src="<?php echo get_movie_poster($pdo, $event->winner_media->id); ?>" class="img-fluid poster" alt="winning movie poster">
										</div>
									</div>
									<?php
								}
								
								?>
								
								<div class="col">
									<table class="table homepage">
										<tbody>
											<?php
											$movie_freshness = Array();
											$movie_years = Array();
											for($ii = 1; $ii <= 12; $ii++):
												$movie_years[] = get_movie_year($pdo,$event->wedges[$ii]->id);
		
												if($event->wedges[$ii]->id != 0){
													$movie_freshness[] = get_movie_avg_rating($pdo, $event->wedges[$ii]->id);
												}
		
												if($event->winning_wedge == $ii){
													echo '<tr class="bold text-white homepage" style="background-color:#'.$event->viewers[$ii]->color.'">';
												}
												else {
													echo '<tr class="homepage">';
												}
		
												?>
													<td class="number homepage"><?php echo $ii; ?></td>
													<td class="viewer-name text-center homepage" ><?php echo $event->viewers[$ii]->name; ?></td>
													<td class="movie-title homepage"><?php echo $event->wedges[$ii]->name; ?></td>
												</tr>
		
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
								<div class="card card-body">
									<?php
									$movie_years = array_filter($movie_years);
									$attendees = explode(",", $event->attendees);
									$viewers = Array();
									foreach($attendees as $person){
										$viewers[] = getMoviegoerById($person);
									}
									?>
									<ul>
										<li><strong>Attendees:</strong> <?php echo implode(", ", $viewers);?>
										<li><strong>Scribe:</strong> <?php echo $event->scribe->name; ?></li>
										<li><strong>Spinner:</strong> <?php echo $event->spinner->name; ?></li>
										<li><strong>Bad Spin #s:</strong> <?php echo $event->error_spin; ?></li>
										<li><strong>Theme/Comment:</strong> <?php echo $event->theme; ?></li>
										<li><strong>Movie Format:</strong> <?php echo $event->format; ?></li>
										<li><strong>Selection Tool:</strong> <?php echo $event->selection_method; ?></li>
										<li><strong>Runtime:</strong> <?php echo $event->runtime; ?> minutes</li>
										<li><strong>MPAA:</strong> <?php echo $event->winner_media->mpaa; ?></li>
										<li><strong>Collective Movie Score:</strong> <?php echo get_freshness($movie_freshness); ?>%</li>
										<li><strong>Winning Movie Score:</strong> <?php echo get_movie_avg_rating($pdo,$event->winner_media->id); ?></li>
										<li><strong>Average Movie Year:</strong> <?php echo round(array_sum($movie_years)/count($movie_years)); ?></li>
										<li><strong>Winning Movie Year:</strong> <?php echo $event->winner_media->year;?></li>
									</ul>
								</div>
							</div>



						</div>
					</div>
				</div>
				<?php ?>
			<?php endforeach;?>

			<script>nanobar.go(100);</script>
		</div>
		
		
		
	</div>
</div>

<?php template('footer'); ?>
