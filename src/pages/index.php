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

	<!-- Header -->
	<h1 class="text-center">Yes, we made a website for this.</h1>
	<p class="text-center mb-3">
		<?php
		$minutes = $event_list->sum_watchtime();
		echo 'Over ' . number_format($minutes) . ' minutes of "entertainment." ';
		echo '(Or ' . round(( $minutes / 60 ), 2) . ' hours.) ';
		echo '(Or ' . round(( $minutes / 60 ) / 24, 2) . ' days.)';
		?>
	</p>

	<!-- Controls -->
	<div class="row justify-content-center align-items-end">
		<div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-3">
			<label for="ctrl-numbers" class="form-label">Numbering System</label>
			<select id="ctrl-numbers" class="form-input form-select" onchange="set_mns_numbers(this.value)">
				<option value="arabic">Arabic</option>
				<option value="roman">Roman Numerals</option>
				<option value="japanese">Japanese Kanji</option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-3">
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
	</div>


	<div class="row justify-content-center mns-events mns-view-cards">
		<?php

		$i = 0;

		foreach ($event_list->events as $event):
			$i++;
			?>

			<div class="mb-3 col-12 <?php echo ( $i == 1 ) ? 'col-lg-8' : 'col-md-6 col-lg-4'; ?>">
				<div class="card shadow">

					<!-- Card Header -->
					<div
						class="card-header text-center"
						style="<?php echo $event->winner['viewer']->css_style_color(); ?>">
						<div class="title-event-number">
							Event
							<span data-mns-number="<?php echo $count_events; ?>"><?php echo $count_events--; ?></span>
						</div>
						<div class="title-event-date">
							<?php echo $event->date->long(); ?>
						</div>
					</div>

					<!-- Card Body -->
					<div class="card-body">
						<div class="row">
							<?php

							if ($i == 1) {
								?>
								<div class="col-12 col-md-auto">
									<div class="justify-content-center">
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
								<table class="table movie-list bg-clear">
									<tbody>
									<?php
									$movie_freshness = [];
									for ($ii = 1; $ii <= 12; $ii++):

										if ($event->wedges[$ii]['media']->id != 0) {
											$movie_freshness[] = $event->wedges[$ii]['media']->reviews->average();
										}

										if ($event->winning_wedge == $ii) {
											echo '<tr class="list-winner" style="' . $event->winner['viewer']->css_style_color() . '">';
										}
										else {
											echo '<tr>';
										}


										?>
										<td class="list-number" data-mns-number="<?php echo $ii; ?>">
											<?php echo $ii; ?>
										</td>
										<td class="list-viewer">
											<?php echo $event->wedges[$ii]['viewer']->name; ?>
										</td>
										<td
											class="list-title"
											title="<?php echo $event->wedges[$ii]['media']->name; ?>">
											<?php echo $event->wedges[$ii]['media']->name; ?>
										</td>
										</tr>

									<?php endfor; ?>
									</tbody>
								</table>
							</div>
						</div>


						<div class="collapse" id="collapse_<?php echo $count_events; ?>">
							<div class="card mt-3">
								<?php
								$attendees = explode(",", $event->attendees);
								$viewers = [];
								foreach ($attendees as $person) {
									$viewers[] = $event->viewer_list->get_by_id(trim($person))->name;
								}
								?>
								<div class="card-header">
									Details
								</div>
								<ul class="list-group list-group-flush">
									<?php if ($event->theme): ?>
										<li class="list-group-item">
											<strong>Theme:</strong>
											<?php echo $event->theme; ?>
										</li>
									<?php endif; ?>
									<li class="list-group-item">
										<strong>Attendees:</strong>
										<?php echo implode(', ', $viewers); ?>
									</li>
									<li class="list-group-item">
										<strong>Scribe:</strong>
										<?php echo $event->scribe->name; ?>
									</li>
									<li class="list-group-item">
										<strong>Spinner:</strong>
										<?php echo $event->spinner->name; ?>
									</li>
									<?php if (sizeof($event->error_spins)): ?>
										<li class="list-group-item">
											<strong>Bad Spin #s:</strong>
											<?php echo implode(', ', $event->error_spins); ?>
										</li>
									<?php endif; ?>
									<li class="list-group-item">
										<strong>Format:</strong>
										<?php echo $event->format->name; ?>
									</li>
									<li class="list-group-item">
										<strong>Selection Tool:</strong>
										<?php echo $event->selection_method->name; ?>
									</li>
									<li class="list-group-item">
										<strong>Runtime:</strong>
										<?php echo $event->runtime; ?> minutes
									</li>
									<li class="list-group-item">
										<strong>MPAA #:</strong>
										<?php echo $event->winner['media']->mpaa; ?>
									</li>
									<li class="list-group-item">
										<strong>Collective Movie Score:</strong>
										<?php echo $event->average_rating(); ?>%
									</li>
									<li class="list-group-item">
										<strong>Winning Movie Score:</strong>
										<?php echo $event->winner['media']->reviews->average(); ?>%
									</li>
									<li class="list-group-item">
										<strong>Average Movie Year:</strong>
										<?php echo $event->average_year(); ?>
									</li>
									<li class="list-group-item">
										<strong>Winning Movie Year:</strong>
										<?php echo $event->winner['media']->year; ?>
									</li>
								</ul>
							</div>
						</div>


					</div>

					<a
						class="card-footer text-center py-3"
						data-bs-toggle="collapse"
						href="#collapse_<?php echo $count_events; ?>"
						aria-expanded="false"
						aria-controls="collapse_<?php echo $count_events; ?>">
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
