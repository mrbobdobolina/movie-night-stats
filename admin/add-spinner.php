<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

if(!empty($_POST)){
	if(
		!empty($_POST['name']) &&
		!empty($_POST['color_1']) && !empty($_POST['color_2']) && !empty($_POST['color_3']) &&
		!empty($_POST['color_4']) && !empty($_POST['color_5']) && !empty($_POST['color_6']) &&
		!empty($_POST['color_7']) && !empty($_POST['color_8']) && !empty($_POST['color_9']) &&
		!empty($_POST['color_10']) && !empty($_POST['color_11']) && !empty($_POST['color_12'])
	){
		$query = sprintf(
			"INSERT INTO `spinners` SET `name`='%s',".
			"`wedge_1`='%s',`wedge_2`='%s',`wedge_3`='%s',`wedge_4`='%s',".
			"`wedge_5`='%s',`wedge_6`='%s',`wedge_7`='%s',`wedge_8`='%s',".
			"`wedge_9`='%s',`wedge_10`='%s',`wedge_11`='%s',`wedge_12`='%s', `uses`='0'",

			db_esc($_POST['name'] ?? ''),

			db_esc($_POST['color_1'] ?? ''),
			db_esc($_POST['color_2'] ?? ''),
			db_esc($_POST['color_3'] ?? ''),

			db_esc($_POST['color_4'] ?? ''),
			db_esc($_POST['color_5'] ?? ''),
			db_esc($_POST['color_6'] ?? ''),

			db_esc($_POST['color_7'] ?? ''),
			db_esc($_POST['color_8'] ?? ''),
			db_esc($_POST['color_9'] ?? ''),

			db_esc($_POST['color_10'] ?? ''),
			db_esc($_POST['color_11'] ?? ''),
			db_esc($_POST['color_12'] ?? '')
		);

		db($query);

		$alert = [
			'color' => 'success',
			'msg' => 'Success! Spinner added to database!'
		];
	}
	else {
		$alert = [
			'color' => 'danger',
			'msg' => 'Error! You need to fill out all the fields.'
		];
	}
}

include('template/header.php');

?>
<h1 class="display-6 text-center">Add a Spinner</h1>
<div class="text-center mb-5">Really?</div>

<?php

if(!empty($alert)){
	echo '<div class="alert alert-'.$alert['color'].' alert-dismissible fade show" role="alert">';
	echo $alert['msg'];
	echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
	echo '</div>';
}

?>

<div class="row justify-content-center">
	<div class="col-12 col-md-8 col-lg-6 col-xl-5">

		<div class="card mb-3">
			<div class="card-body">

				<form action="#" method="POST">
					<div class="row mb-3">
						<label for="name" class="col-4 col-form-label">Spinner Name</label>
						<div class="col-8">
							<input id="name" name="name" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 1</label>
						<div class="col-8">
							<input id="color_1" name="color_1" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 2" class="col-4 col-form-label">Color 2</label>
						<div class="col-8">
							<input id="color_2" name="color_2" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 3" class="col-4 col-form-label">Color 3</label>
						<div class="col-8">
							<input id="color_3" name="color_3" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color " class="col-4 col-form-label">Color 4</label>
						<div class="col-8">
							<input id="color_4" name="color_4" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 5</label>
						<div class="col-8">
							<input id="color_5" name="color_5" type="text" class="form-control">
						</div>
					</div>
				 	<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 6</label>
						<div class="col-8">
							<input id="color_6" name="color_6" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 7</label>
						<div class="col-8">
							<input id="color_7" name="color_7" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 8</label>
						<div class="col-8">
							<input id="color_8" name="color_8" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 9</label>
						<div class="col-8">
							<input id="color_9" name="color_9" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 10</label>
						<div class="col-8">
							<input id="color_10" name="color_10" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 11</label>
						<div class="col-8">
							<input id="color_11" name="color_11" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color 1" class="col-4 col-form-label">Color 12</label>
						<div class="col-8">
							<input id="color_12" name="color_12" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<div class="offset-4 col-8">
							<button name="submit" type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</form>

			</div>
		</div>

	</div>
	<div class="col-12 col-md-4">
		<div class="card mb-3">
			<div class="card-header">
				Existing Spinners
			</div>
			<div class="card-body">
				<ul>
					<?php
						foreach(getSelectionTypes(TRUE) as $selection){
							echo '<li>'.$selection.'</li>';
						}
					?>
				</ul>
			</div>

		</div>

	</div>
</div>

<?php

include('template/footer.php')

?>
