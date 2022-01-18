<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');


$movies = getMovieList();

$movieSelect = "<option disabled selected></option>";

foreach($movies as $aFilm){
	$movieSelect .= "<option value=\"" . $aFilm["id"] . "\">" . $aFilm["name"] . "</option>";
}

$viewers = getListOfViewers();

$viewerSelect = "<option disabled selected></option>";

foreach($viewers as $aPerson){
	$viewerSelect .= "<option value=\"" . $aPerson["id"] . "\">" . $aPerson["name"] . "</option>";
}


$selectors = getSelectionTypes();

$selectorsSelect = "<option disabled selected></option>";

foreach($selectors as $aTool){
	$selectorsSelect .= "<option value=\"" . $aTool . "\">" . $aTool . "</option>";
}

?>
	  <div class="album py-5 bg-light">
	    <div class="container">
				<h2>Add a Game</h2>

				<form class="form" action="ag.php" method="post">

				<div class="form-group row">
					<label for="date" class="col-sm-1 col-form-label">Date:</label>
					<div class="col-sm-3">
						<input class="form-control" type="date" name="date" id="date" placeholder="yyyy-mm-dd" value="<?php echo date("Y-m-d"); ?>">
					</div>
				</div>
				<div class="col-8">
				<table class="table">
					<thead>
						<tr>
							<th>Wedge #</th>
							<th>Movie</th>
							<th>Viewer</th>
						</tr>
					</thead>
					<tbody>
						<?php for($i = 1; $i <= 12; $i++):?>
							<tr>
								<td><?php echo $i;?></td>
								<td>
									<select class="form-select" name="wedge_<?php echo $i;?>" id="wedge_<?php echo $i;?>">
										<?php echo $movieSelect; ?>
									</select>
								</td>
								<td>
									<select class="form-select" name="viewer_<?php echo $i;?>" id="viewer_<?php echo $i;?>">
										<?php echo $viewerSelect; ?>
									</select>
								</td>
							</tr>
						<?php endfor;?>
					</tbody>
				</table>
			</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Spinner: </label>
					<select class="form-select" name="spinner" id="spinner">
					  <?php echo $viewerSelect; ?>
					</select>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="winning_wedge">Winning Number: </label>
					<select class="form-select" name="winning_wedge" id="winning_wedge">
						<?php
						for($i = 1; $i < 13; $i++){
							echo "<option value='".$i."'>".$i."</option>";
						}?>
					</select>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Format: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="format" id="format">
					</div>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Error Spin(s): </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="errors" id="errors">
					</div>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Selection Method: </label>
					<select class="form-select" name="selection_method" id="selection_method">
					  <?php echo $selectorsSelect; ?>
					</select>
				</div>

				<div class="form-row col-4 mt-3">
					<label for="spinner">Scribe: </label>
					<select class="form-select" name="scribe" id="scribe">
					  <?php echo $viewerSelect; ?>
					</select>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Theme: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="theme" id="theme">
					</div>
				</div>

				<div class="form-group row  mt-3">
					<label for="date" class="col-sm-1 col-form-label">Runtime: </label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="runtime" id="runtime">
					</div>
				</div>

			 <div class="form-group row  mt-3">
			    <label class="col-2">Attendees: </label>
			    <div class="col-8">
								<?php
								foreach($viewers as $key => $value):?>
							 <div class="custom-control custom-checkbox custom-control-inline">
							        <input name="attendees[]" id="attendees_<?php echo $value['id']; ?>" type="checkbox" class="custom-control-input" value="<?php echo $value['id']; ?>">
							        <label for="attendees_<?php echo $value['id']; ?>" class="custom-control-label"><?php echo $value['name']; ?></label>
							      </div>
							<?php endforeach;?>
						</div>
						</div>


				<input class="btn btn-primary" type="submit" value="Submit">


			</form>
	    </div>
	  </div>
		<?php

		include('template/footer.php')

		?>
