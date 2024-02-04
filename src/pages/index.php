<div style="background: var(--mns-primary-bg);">
	<div class="container">
		<img
			alt="Movie Night Stats"
			src="/images/MovieNightStats_v02B_Rectangle_Transparent.png"
			style="max-height: 15rem; max-width: 100%; display:block; margin: 0 auto;">
	</div>
</div>

<main class="container my-4">

	<?php

	$viewer_list = new Viewer_List();
	$viewer_list->init();

	$event_list = new Event_List($viewer_list);
	$event_list->init();
	$count_events = count($event_list->events());

	?>



	<p class="display-6 text-center">Yes, we made a website for this.</p>
	<p class="text-center mb-3">
		<?php
		$minutes = $event_list->sum_watchtime();
		echo 'Over ' . number_format($minutes) . ' minutes of "entertainment." ';
		echo '(Or ' . round(( $minutes / 60 ), 2) . ' hours.) ';
		echo '(Or ' . round(( $minutes / 60 ) / 24, 2) . ' days.)';
		?>
	</p>

	<div class="row justify-content-center align-items-end">
		<div class="col-3 mb-3">
			<button
				id="btn-expand-all"
				class="btn btn-outline-primary form-control"
				onclick="$('main .collapse').collapse('show'); $('#btn-expand-all').hide(); $('#btn-collapse-all').show();">
				<i class="fa-solid fa-angles-down"></i> Expand ALL Details
			</button>
			<button
				id="btn-collapse-all"
				class="btn btn-outline-danger form-control"
				onclick="$('main .collapse').collapse('hide'); $('#btn-expand-all').show(); $('#btn-collapse-all').hide();"
				style="display:none">
				<i class="fa-solid fa-angles-up"></i> Collapse ALL Details
			</button>
		</div>
		<div class="col-3 mb-3">
			<label for="ctrl-numbers" class="form-label">Numbers</label>
			<select id="ctrl-numbers" class="form-input form-select" onchange="set_mns_numbers(this.value)">
				<option value="arabic">Arabic</option>
				<option value="roman">Roman Numerals</option>
				<option value="japanese">Japanese Kanji</option>
			</select>
		</div>
	</div>


	<div class="row justify-content-center">
		<?php

		$i = 0;

		foreach ($event_list->events as $event):
			$i++;
			?>

			<div
				class="mb-3 col-12 <?php if ($i == 1) {
					echo 'col-md-8';
				}
				else {
					echo 'col-md-6 col-lg-4';
				} ?>">
				<div class="card shadow">

					<!-- Card Header -->
					<div
						class="card-header pt-2 pb-1 text-center text-white lead"
						style="background-color:#<?php echo $event->winner['viewer']->color; ?>">
						<h3>Event
							<span data-mns-number="<?php echo $count_events; ?>"><?php echo $count_events--; ?></span>
						</h3>
						<small><em><?php echo $event->date->long(); ?></em></small>
					</div>

					<!-- Card Body -->
					<div class="card-body">
						<div class="row">
							<?php

							if ($i == 1) {
								?>
								<div class="col">
									<div class="card-body text-center justify-content-center">
										<img
											src="<?php echo $event->winner['media']->poster_url; ?>"
											class="img-fluid poster"
											alt="winning movie poster">
									</div>
								</div>
								<?php
							}

							?>

							<div class="col">
								<table class="table homepage">
									<tbody>
									<?php
									$movie_freshness = [];
									for ($ii = 1; $ii <= 12; $ii++):

										if ($event->wedges[$ii]['media']->id != 0) {
											$movie_freshness[] = $event->wedges[$ii]['media']->reviews->average();
										}

										if ($event->winning_wedge == $ii) {
											echo '<tr class="bold text-white homepage" style="background-color:#' . $event->wedges[$ii]['viewer']->color . '">';
										}
										else {
											echo '<tr class="homepage">';
										}

										?>
										<td class="number homepage" data-mns-number="<?php echo $ii; ?>"><?php echo $ii; ?></td>
										<td class="viewer-name text-center homepage"><?php echo $event->wedges[$ii]['viewer']->name; ?></td>
										<td class="movie-title homepage"><?php echo $event->wedges[$ii]['media']->name; ?></td>
										</tr>

									<?php endfor; ?>
									</tbody>
								</table>
							</div>
						</div>


						<div class="collapse" id="collapseExample_<?php echo $count_events; ?>">
							<div class="card card-body">
								<?php
								$attendees = explode(",", $event->attendees);
								$viewers = [];
								foreach ($attendees as $person) {
									$viewers[] = $event->viewer_list->get_by_id(trim($person))->name;
								}
								?>
								<ul>
									<li><strong>Attendees:</strong> <?php echo implode(', ', $viewers); ?>
									<li><strong>Scribe:</strong> <?php echo $event->scribe->name; ?></li>
									<li><strong>Spinner:</strong> <?php echo $event->spinner->name; ?></li>
									<li><strong>Bad Spin #s:</strong> <?php echo implode(', ', $event->error_spins); ?>
									</li>
									<li><strong>Theme/Comment:</strong> <?php echo $event->theme; ?></li>
									<li><strong>Movie Format:</strong> <?php echo $event->format->name; ?></li>
									<li><strong>Selection Tool:</strong> <?php echo $event->selection_method->name; ?>
									</li>
									<li><strong>Runtime:</strong> <?php echo $event->runtime; ?> minutes</li>
									<li><strong>MPAA:</strong> <?php echo $event->winner['media']->mpaa; ?></li>
									<li><strong>Collective Movie Score:</strong> <?php echo $event->average_rating(); ?>
										%
									</li>
									<li><strong>Winning Movie
											Score:</strong> <?php echo $event->winner['media']->reviews->average(); ?>%
									</li>
									<li><strong>Average Movie Year:</strong> <?php echo $event->average_year(); ?></li>
									<li><strong>Winning Movie
											Year:</strong> <?php echo $event->winner['media']->year; ?>
									</li>
								</ul>
							</div>
						</div>


					</div>

					<a
						class="card-footer text-center py-3"
						data-bs-toggle="collapse"
						href="#collapseExample_<?php echo $count_events; ?>"
						aria-expanded="false"
						aria-controls="collapseExample_<?php echo $count_events; ?>">
						Toggle Details
					</a>

				</div>
			</div>

			<?php

			if ($i == 1) {
				echo '<div class="w-100"></div>';
			}

			?>
		<?php endforeach; ?>
	</div>


	<script>
		$(function () {
			$('#ctrl-numbers').val(get_mns_numbers());
		});
	</script>
</main>
