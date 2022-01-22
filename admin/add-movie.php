<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

if(!empty($_POST)){

	if(!empty($_POST['name'])){
		// Make sure this isn't duplicate name
		$query = sprintf("SELECT * FROM `films` WHERE `name`='%s'", db_esc($_POST['name']));
		if(db($query) == NULL){

			$query2 = sprintf(
				"INSERT INTO `films` SET `name`='%s',`year`='%s',`runtime`='%s',`imdb`='%s',`tomatometer`='%s',`rt_audience`='%s',`MPAA`='%s'",
				db_esc($_POST['name']),
				db_esc($_POST['year'] ?? ''),
				db_esc($_POST['runtime'] ?? ''),
				db_esc($_POST['imdb'] ?? ''),
				db_esc($_POST['rt_rating'] ?? ''),
				db_esc($_POST['rta_rating'] ?? ''),
				db_esc($_POST['mpaa'] ?? '')
			);

			db($query2);

			$alert = [
				'color' => 'success',
				'msg' => 'Success! Movie added to database!'
			];

		}
		else {
			$alert = [
				'color' => 'danger',
				'msg' => 'Error! That movie is already in the database.'
			];
		}
	}
	else {
		$alert = [
			'color' => 'danger',
			'msg' => 'Error! Movies must have a name.'
		];
	}

}

include('template/header.php');

?>
<h1 class="display-6 text-center">Add a movie</h1>
<div class="text-center mb-5">Kinda feels like you already have enough of those...</div>

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
				<form action="#" method="post">
					<div class="row mb-3">
						<label for="name" class="col-4 col-form-label">Movie Name</label>
						<div class="col-8">
							<input id="name" name="name" type="text" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="year" class="col-4 col-form-label">Movie Year</label>
						<div class="col-8">
							<input id="year" name="year" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="runtime" class="col-4 col-form-label">Movie Runtime</label>
						<div class="col-8">
							<input id="runtime" name="runtime" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="imdb" class="col-4 col-form-label">IMDB Rating</label>
						<div class="col-8">
							<input id="imdb" name="imdb" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="rt_rating" class="col-4 col-form-label">RT Rating</label>
						<div class="col-8">
							<input id="rt_rating" name="rt_rating" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="rta_rating" class="col-4 col-form-label">RT Audience Rating</label>
						<div class="col-8">
							<input id="rta_rating" name="rta_rating" type="number" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="mpaa" class="col-4 col-form-label">MPAA</label>
						<div class="col-8">
							<input id="mpaa" name="mpaa" type="number" class="form-control">
						</div>
					</div>

					<div class="form-group row">
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
				Existing Movies
			</div>
			<div class="card-body">
				<ul>
					<?php

					foreach(getMovieList() as $movie){
						echo '<li>'.$movie['name'].' <em>('.$movie['id'].')</em></li>';
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
