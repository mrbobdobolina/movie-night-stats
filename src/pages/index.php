<div class="container my-3">

	<?php

	$viewer_list = new Viewer_List();
	$viewer_list->init();

	$event_list = new Event_List($viewer_list);
	$event_list->init();
	$count_events = count($event_list->events());

	?>

	<p class="display-6 text-center">Yes! We made a website for this.</p>
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
				onclick="$('.collapse').collapse('show'); $('#btn-expand-all').hide(); $('#btn-collapse-all').show();">
				<i class="fa-solid fa-angles-down"></i> Expand ALL Details
			</button>
			<button
				id="btn-collapse-all"
				class="btn btn-outline-danger form-control"
				onclick="$('.collapse').collapse('hide'); $('#btn-expand-all').show(); $('#btn-collapse-all').hide();"
				style="display:none">
				<i class="fa-solid fa-angles-up"></i> Collapse ALL Details
			</button>
		</div>
		<div class="col-3 mb-3">
			<label for="ctrl-numbers" class="form-label">Numbers</label>
			<select id="ctrl-numbers" class="form-input form-select" onchange="switch_event_numbers(this.value)">
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
							<span data-event-number="<?php echo $count_events; ?>"><?php echo $count_events--; ?></span>
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
										<td class="number homepage"><?php echo $ii; ?></td>
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

			if($i==1){
				echo '<div class="w-100"></div>';
			}

			?>
		<?php endforeach; ?>
	</div>


	<script>
		function arabic_to_roman_numerals($number) {
			let $lookup = {
				M: 1000, CM: 900,
				D: 500, CD: 400,
				C: 100, XC: 90,
				L: 50, XL: 40,
				X: 10, IX: 9,
				V: 5, IV: 4,
				I: 1,
			};

			let $roman_numeral = '';

			for (let $i in $lookup) {
				while ($number >= $lookup[$i]) {
					$roman_numeral += $i;
					$number -= $lookup[$i];
				}
			}

			return $roman_numeral;
		}

		function arabic_to_japanese_kanji($number) {
			const $count_thousands = Math.floor($number / 1000);
			const $count_hundreds = Math.floor($number % 1000 / 100);
			const $count_tens = Math.floor($number % 1000 % 100 / 10);
			const $count_ones = Math.floor($number % 1000 % 100 % 10);

			const $kanji = {
				1: '一', 2: '二', 3: '三', 4: '四', 5: '五', 6: '六', 7: '七', 8: '八', 9: '九',
				10: '十',
				100: '百',
				1000: '千',
			};

			let $value = '';

			if ($count_thousands) {
				$value += ( ( $count_thousands > 1 ) ? $kanji[$count_thousands] : '' ) + $kanji[1000];
			}
			if ($count_hundreds) {
				$value += ( ( $count_hundreds > 1 ) ? $kanji[$count_hundreds] : '' ) + $kanji[100];
			}
			if ($count_tens) {
				$value += ( ( $count_tens > 1 ) ? $kanji[$count_tens] : '' ) + $kanji[10];
			}
			if ($count_ones) {
				$value += $kanji[$count_ones];
			}

			return $value;
		}

		function set_event_numbers($type) {

			$('*[data-event-number]').each(($i, $element) => {
				let $this = $($element);
				const $number = parseInt($this.attr('data-event-number'));
				let $value;

				switch ($type) {
					case 'roman':
						$value = arabic_to_roman_numerals($number);
						break;
					case 'japanese':
						$value = arabic_to_japanese_kanji($number);
						break;
					default:
						$value = $number;
				}

				$this.html($value);
			});

		}

		function switch_event_numbers($value) {
			localStorage.setItem('event-numbers', $value);
			set_event_numbers($value);
		}

		$(function () {
			const $event_numbers = localStorage.getItem('event-numbers');
			$('#ctrl-numbers').val($event_numbers);
			set_event_numbers($event_numbers);
		});
	</script>
</div>
