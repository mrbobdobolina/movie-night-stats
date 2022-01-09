<?php

require_once('common.php');

template('header');

?>


  <div class="album py-5 bg-light">
    <div class="container">
			<p class="display-6 text-center">Attendance, Selection, Winners: visualized.</p>

<table class="table table-sm">
	<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="col-2">Date</th>

		<?php $viewers = getListOfViewers('attendance', 'DESC'); ?>

		<?php foreach($viewers as $viewer):?>
			<th class="text-center"><?php echo $viewer['name']; ?></th>
		<?php endforeach;?>
	</tr>
	</thead>
	<tbody>
				<?php foreach($events as $event):?>
	       <tr>
					 <td class="text-center"><?php echo $count_events--;?></td>
					 <td><?php
						 $theDate = new DateTime($event['date']);

						  echo $theDate->format('F j, Y'); ?>
						</td>

						 <?php $present = explode(",",$event['attendees']);?>
			 		<?php foreach($viewers as $viewer):?>

								<?php if(in_array($viewer['id'], $present)):?>
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
										} ?>
										<?php echo $html;?>
									</td>
										<?php else:?>
											<td></td>
								<?php endif;?>

			 		<?php endforeach;?>
				 </tr>
				<?php endforeach;?>
			</tbody>
</table>


    </div>
  </div>

</main>

<?php template('footer');?>
