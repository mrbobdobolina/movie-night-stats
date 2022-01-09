<?php require_once("header.php"); ?>
  <div class="album py-5 bg-light">
    <div class="container">
			<p class="display-6 text-center "><?php echo countMovieList();?> Films We Could Have Watched</p>
			<p class="lead text-center ">(And the <?php echo countWatchedMovies();?> we did.)</p>

			<div class="row">
				<p><i class="fas fa-star" style="color:#FFFF00;"></i> Indicates movie was picked its first night on the wheel. <span style="background-color:#82D173;">Green row indicates movie won at least once.</span></p>
				
				<table id="movies" class="table table-striped">
				  <thead>
				    <tr>
				      <th><i class="fas fa-star"></i></th>
			
				      <th class="col-2">Title</th>
							<th>Year</th>
							<th class="text-end">MPAA#</th>
							<th class="text-end">Runtime</th>
							<th class="text-end"><i class="far fa-frown"></i><i class="far fa-meh"></i><i class="far fa-smile"></i></th>
				      <th><i class="fas fa-trophy"></i></th>
				      <th><i class="far fa-cheese"></i></th>
							<!-- <th>% of Wedges</th> -->
							<th><i class="fas fa-house-night"></i></th>
							<!-- <th>% of Nights</th>-->
							<th>First Date</th>
							<th>Last Date</th>
							<th class="col-2">Pickers</th>
				    </tr>
				  </thead>
				  <tbody>
						<?php $movies = getMovieList(); 
						$week_count = countWeeks();
						$total_wedges = countWeeks()*12;
						$oneHitWonders = 0;
						?>
						<?php foreach($movies as $movie): ?>		
							<?php $winner = didIWin($movie['id']); 
							//$first_date = getFirstOrLastDate($movie['id'], "First"); 
							
							$wedges = countTotalFilmApperances($movie['id']);
							$weeks = countWeeksOnWheel($movie['id']);?>
							
							<?php if($winner['count'] > 0):?>	
								<tr style="background-color:#82D173;">
							<?php else:?>
								<tr>
							<?php endif;?>
					    
					      <td><?php if($winner['first_win'] == $movie['first_instance']){echo '<i class="fas fa-star" style="color:#FFFF00;"></i>'; $oneHitWonders++; }?></td>

					      <td><?php echo $movie['name']; ?> </td>
								<td class="text-center"><?php echo $movie['year']; //get_movie_year($movie['id']); ?></td>
								<td class="text-end mpaa"><?php echo $movie['MPAA']; ?></td>
								<td class="text-end"><?php echo $movie['runtime']; ?></td>
								<td class="text-end"><?php echo getMovieRatingReal($movie['id']); ?></td>
					      <td class="text-center"><?php echo $winner['count']; ?></td>
								<td class="text-center"><?php echo $wedges; ?></td>
								<!-- <td class="text-end"><?php //echo round(($wedges/$total_wedges)*100,2);?>%</td>-->
								<td class="text-center"><?php echo $weeks; ?></td>
								<!-- <td class="text-end"><?php //echo round(($weeks/$week_count)*100,2);?>%</td>-->
								<td><?php echo $movie['first_instance']; ?></td>
								<td><?php echo $movie['last_instance'];?></td>
								<td><?php
									$pickers = getPickers_v3($movie['id']);
									//print_r($pickers);
									$pickerArray = Array();
									foreach($pickers as $viewer => $count){
										$pickerArray[] = getViewerName($viewer) . " (".$count.")";
									}
									echo implode(", ", $pickerArray);
									?></td>
					    </tr>
						<?php endforeach; ?>
				  </tbody>
				</table>
				
				We've had a total of <?php echo $oneHitWonders; ?> "One Hit Wonders".
				
			</div>
    </div>
  </div>

</main>
<script>
	$(document).ready(function() {
	    $('#movies').DataTable(
	    	{
					"pageLength": 100,
					 "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
					"order": [[ 1, "asc" ]]
	    	}
	    );
	} );
	</script>

<?php include("footer.php");?>