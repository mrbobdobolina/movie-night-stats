<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');

?>
<div class="album py-5 bg-light">
  <div class="container">
		<p class="display-6 text-center mb-5">Random Assignments.</p>
		<?php if(isset($_POST)){
			foreach($_POST['attendees'] as $person){
				$people[] = getMoviegoerById($person);
			}
			//print_r($people);
		}?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">
				<form action="add-list.php" method="post">
				<?php
				$viewers = getListOfViewers();
				foreach($viewers as $key => $value):?>
			 <div class="custom-control custom-checkbox custom-control-inline">
			        <input name="attendees[]" id="attendees_<?php echo $value['id']; ?>" type="checkbox" class="custom-control-input" value="<?php echo $value['id']; ?>">
			        <label for="attendees_<?php echo $value['id']; ?>" class="custom-control-label"><?php echo $value['name']; ?></label>
			      </div>

			<?php endforeach;?>
			<input type="submit" value="Submit">
			</form>

			<div class="card-body">
				<?php //$people = Array("Philip", "TV", "Holly");
				shuffle($people);
				$count = count($people);
				$ii = 0;
				$list = Array();

				$date = new DateTime('NOW');

				echo $date->format('F j, Y') . " Movie List<br />";?>

				<?php for($i = 0; $i <= 11; $i++){

					$list[$i+1] = $people[$ii];

					//echo $i+1 .".  ". "(".$people[$ii].")<br />";

					$ii++;

					if($ii >= $count){
						$ii = 0;
					}

				}

				if(random_int(1,3) == 1){
					shuffle($list);
					foreach($list as $key => $value){
						echo $key+1 . ". " . "(".$value.") <br />";
					}
				} else {
					foreach($list as $key => $value){
						echo $key . ". " . "(".$value.") <br />";
					}
				}



				?>
			</div>


			</div>

  </div>
</div>
<?php

include('template/footer.php')

?>
