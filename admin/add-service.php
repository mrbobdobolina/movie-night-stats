<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

if(!empty($_POST)){
	if(!empty($_POST['name']) && !empty($_POST['color'])){
		$query = sprintf(
			"INSERT INTO `services` SET `name`='%s', `rgba`='%s'",
			db_esc($_POST['name']),
			db_esc($_POST['color'])
		);

		db($query);

		$alert = [
			'color' => 'success',
			'msg' => 'Success! Added new viewer!'
		];
	}
	else if(empty($_POST['name']) && empty($_POST['color'])){
		$alert = [
			'color' => 'danger',
			'msg' => 'Error! Please enter a name and color.'
		];
	}
	else if(empty($_POST['name'])) {
		$alert = [
			'color' => 'danger',
			'msg' => 'Error! Please enter a name.'
		];
	}
	else if(empty($_POST['color'])) {
		$alert = [
			'color' => 'danger',
			'msg' => 'Error! Please enter a color.'
		];
	}

}

include('template/header.php');

?>
<h1 class="display-6 text-center">Add a viewer</h1>
<div class="text-center mb-5">Congrats on your new friend, I guess.</div>

<?php

if(!empty($alert)){
	echo '<div class="alert alert-'.$alert['color'].' alert-dismissible fade show" role="alert">';
	echo $alert['msg'];
	echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
	echo '</div>';
}

?>

<div class="row justify-content-center">
	<div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">

		<div class="card mb-3">
			<div class="card-body">
				<form action="#" method="POST">
					<div class="row mb-3">
						<label for="name" class="col-4 col-form-label">Service Name</label>
						<div class="col-8">
							<input id="name" name="name" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="color" class="col-4 col-form-label">Color <em>(rgba)</em></label>
						<div class="col-8">
							<input id="color" name="color" type="text" value="rgba(0,0,0,1)" class="form-control">
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
	<div class="col-12 col-md-4 col-xl-3">

		<div class="card mb-3">
			<div class="card-header">
				Existing Viewers
			</div>
			<div class="card-body">
				<ul>
					<?php

					$viewers = getListOfViewers();
					foreach($viewers as $person){
						echo '<li>'.$person['name'].'</li>';
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
