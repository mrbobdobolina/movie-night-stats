<?php

require_once('common.php');

template('header');

$events = getListOfEvents("DESC");
$count_events = count($events);
$ten_percent = round(($count_events * .1), 0);

$sql = "SELECT `id`, `name`, `color` FROM `viewers` WHERE `attendance` >= $ten_percent ORDER BY `attendance` DESC";
$top_viewers = db($sql);

//print_r($top_viewers);

?>
<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center">Attendance, Selection, Winners: visualized.</p>

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
					<th>with</th>
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
								if(in_array($viewer['id'], $present)): ?>
									<?php $key = array_search($viewer['id'], $present);
									unset($present[$key]);
									?>
									<td style="background-color:#<?php echo $viewer['color'];?>; color:#fff;" class="text-center">
										<?php
											$html = '';
											if($viewer['id'] == $event['spinner']){
												$html = '<i class="fas fa-sync-alt"></i>';
											}
											if($viewer['id'] == $event['winning_moviegoer']){
												if($html == ''){
													$html .= '<i class="far fa-trophy-alt"></i>';
												} else {
													$html .= '&nbsp;<i class="far fa-trophy-alt"></i>';
												}
											}
											echo $html;
										?>
									</td>
								<?php else:?>
									<td></td>
								<?php endif;}
						?>
						<td style="padding:0px"><?php //print_r($present);
						if($present != NULL){
							$dividor = round(100/count($present),0);
							$html2 = '<div class="row m-0">';
							foreach($present as $person){
								$html2 .= '<span style="background-color:#'.getMoviegoerColorById($person).'; color:#fff; margin:0px; padding:4px; display:block; width:'.$dividor.'%;" class="text-center">'.getMoviegoerById($person);
								if($person == $event['spinner']){
									$html2 .= '&nbsp;<i class="fas fa-sync-alt"></i>';
								}
								if($person == $event['winning_moviegoer']){
										$html2 .= '&nbsp;<i class="far fa-trophy-alt"></i>';
								}
								$html2 .= '</span> ';
							}
							$html2 .= "</div>";
							echo $html2;

						}

						?></td>

						<?php endforeach;?>

					</tr>
			</tbody>
		</table>

	</div>
</div>

<?php template('footer');?>
