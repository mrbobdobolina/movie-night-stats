<?php

$viewer_list = new Viewer_List();
$viewer_list->init();

$event_list = new Event_List($viewer_list);
$event_list->init();
$count_events = count($event_list->events());

$numbers = $numberTypes[rand(0,3)];

?>
		
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

		<a href="/events/table" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-table"></i> Table View</a>
		<a href="/events/rows" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-images"></i> Poster View</a>
		<a href="/events/posters" class="btn btn-sm btn-outline-dark mb-3 col-8"><i class="fa-solid fa-image-portrait"></i> Winning Poster</a>
	</div>
	<?php
	
	$i = 0;
	
	foreach($event_list->events() as $event): 
		$i++;
		?>
			
		<div class="mb-3 col-12 <?php if($i == 1) {echo 'col-md-8';} else {echo 'col-md-6 col-lg-4';} ?>">
			<div class="card">

				<!-- Card Header -->
				<div class="card-header pt-2 pb-1 text-center text-white lead" style="background-color:#<?php echo $event->winner['viewer']->color; ?>">
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
									<img src="<?php echo $event->winner['media']->poster_url; ?>" class="img-fluid poster" alt="winning movie poster">
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
									for($ii = 1; $ii <= 12; $ii++):

										if($event->wedges[$ii]['media']->id != 0){
											$movie_freshness[] = $event->wedges[$ii]['media']->reviews->average();
										}

										if($event->winning_wedge == $ii){
											echo '<tr class="bold text-white homepage" style="background-color:#'.$event->wedges[$ii]['viewer']->color.'">';
										}
										else {
											echo '<tr class="homepage">';
										}

										?>
											<td class="number homepage"><?php echo $ii; ?></td>
											<td class="viewer-name text-center homepage" ><?php echo $event->wedges[$ii]['viewer']->name; ?></td>
											<td class="movie-title homepage"><?php echo $event->wedges[$ii]['media']->name; ?></td>
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
							$attendees = explode(",", $event->attendees);
							$viewers = Array();
							foreach($attendees as $person){
								$viewers[] = $event->viewer_list->get_by_id(trim($person))->name;
							}
							?>
							<ul>
								<li><strong>Attendees:</strong> <?php echo implode(', ', $viewers);?>
								<li><strong>Scribe:</strong> <?php echo $event->scribe->name; ?></li>
								<li><strong>Spinner:</strong> <?php echo $event->spinner->name; ?></li>
								<li><strong>Bad Spin #s:</strong> <?php echo implode(', ', $event->error_spins); ?></li>
								<li><strong>Theme/Comment:</strong> <?php echo $event->theme; ?></li>
								<li><strong>Movie Format:</strong> <?php echo $event->format->name; ?></li>
								<li><strong>Selection Tool:</strong> <?php echo $event->selection_method->name; ?></li>
								<li><strong>Runtime:</strong> <?php echo $event->runtime; ?> minutes</li>
								<li><strong>MPAA:</strong> <?php echo $event->winner['media']->mpaa; ?></li>
								<li><strong>Collective Movie Score:</strong> <?php echo $event->average_rating(); ?>%</li>
								<li><strong>Winning Movie Score:</strong> <?php echo $event->winner['media']->reviews->average(); ?>%</li>
								<li><strong>Average Movie Year:</strong> <?php echo $event->average_year(); ?></li>
								<li><strong>Winning Movie Year:</strong> <?php echo $event->winner['media']->year;?></li>
							</ul>
						</div>
					</div>



				</div>
			</div>
		</div>
		<?php ?>
	<?php endforeach;?>
</div>


<?php echo $db_counter; ?>
