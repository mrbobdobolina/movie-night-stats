<?php

template('header');

$events = getListOfEvents("DESC");
$count_events = count($events);
$ten_percent = round(($count_events * .1), 0);

$sql = "SELECT `id`, `name`, `color` FROM `viewers` WHERE `attendance` >= $ten_percent ORDER BY `attendance` DESC";
$top_viewers = db($sql);

?>
<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center">Attendance, Selection, Winners: visualized.</p>
		<p class="text-center mb-5">
			<i class="fas fa-sync-alt px-1"></i> indicates spinner, <i class="far fa-trophy-alt px-1"></i> indicates winner.
		</p>
		<table class="table table-sm">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="col-2">Date</th>
					<?php
						$viewers = $top_viewers;
						foreach($viewers as $viewer){
							echo '<th class="text-center">'.$viewer['name'].'</th>';
						}
					?>
					<th class="text-center">and...</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($events as $event):?>
					<tr>
						<td class="text-center"><?php echo $count_events--;?></td>
						<td>
							<?php
								$theDate = new DateTime($event['date']);
								echo $theDate->format('F j, Y');
							?>
						</td>
						<?php
							$present = explode(",",$event['attendees']);
					 		foreach($top_viewers as $viewer){
								if(in_array($viewer['id'], $present)):
									$key = array_search($viewer['id'], $present);
									unset($present[$key]);
									?>
									<td style="background-color:#<?php echo $viewer['color'];?>; color:#fff;" class="text-center">
										<?php

										if($viewer['id'] == $event['spinner']){
											echo '<i class="fas fa-sync-alt px-1"></i>';
										}
										if($viewer['id'] == $event['winning_moviegoer']){
											echo '<i class="far fa-trophy-alt px-1"></i>';
										}

										?>
									</td>
								<?php else:?>
									<td></td>
								<?php endif;}
						?>
						<td style="padding:0px">
							<div class="row m-0">
								<?php

								// Everyone left in present has a spotty attendance record
								// Lump them all in the last column
								foreach($present as $person){
									echo '<div class="col-12 col-lg text-center" style="background-color:#'.getMoviegoerColorById($person).'; color:#fff; padding:4px;">';
									echo '<span class="fw-bold px-1">'.getMoviegoerById($person).'</span>';

									if($person == $event['spinner']){
										echo '<i class="fas fa-sync-alt px-1"></i>';
									}
									if($person == $event['winning_moviegoer']){
										echo '<i class="far fa-trophy-alt px-1"></i>';
									}
									echo '</div> ';
								}

								?>
							</div>
						</td>

						<?php endforeach;?>

					</tr>
			</tbody>
		</table>

	</div>
</div>

<?php template('footer');?>
