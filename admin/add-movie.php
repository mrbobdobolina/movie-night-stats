<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

if(!empty($_POST)){

	switch ($_POST['submit']) {
		case 'addFilm':
			if(!empty($_POST['name'])){
				// Make sure this isn't duplicate name
				$query = sprintf("SELECT * FROM `films` WHERE `name`='%s'", db_esc($_POST['name']));
				if(db($query) == NULL){

					$query2 = sprintf(
						"INSERT INTO `films` SET `name`='%s',`year`='%s',`runtime`='%s',`imdb`='%s',`tomatometer`='%s',`rt_audience`='%s',`MPAA`='%s', `imdb_id`='%s', `poster_url`='%s'",
						db_esc($_POST['name']),
						db_esc($_POST['year'] ?? ''),
						db_esc($_POST['runtime'] ?? ''),
						db_esc($_POST['imdb'] ?? NULL),
						db_esc($_POST['rt_rating'] ?? NULL),
						db_esc($_POST['rta_rating'] ?? NULL),
						db_esc($_POST['mpaa'] ?? ''),
						db_esc($_POST['imdbid'] ?? ''),
						db_esc($_POST['poster'] ?? '')
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
			break;

		case 'search':
			$movie_name = $_POST['sname'];

			$movie_info_url = "http://www.omdbapi.com/?t=".str_replace(" ","+",$movie_name)."&apikey=".OMDB_API_KEY;
			$movie_info = json_decode(file_get_contents($movie_info_url), true);

			break;

		default:
			// code...
			break;
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
							<input id="name" name="name" type="text" value="<?php if(isset($_POST['sname'])){echo $movie_info['Title'];}?>" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="year" class="col-4 col-form-label">Movie Year</label>
						<div class="col-8">
							<input id="year" name="year" type="number" value="<?php if(isset($movie_info['Year'])){echo $movie_info['Year'];}?>" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="runtime" class="col-4 col-form-label">Movie Runtime</label>
						<div class="col-8">
							<input id="runtime" name="runtime" type="number" value="<?php if(isset($movie_info['Runtime'])){echo strtok($movie_info['Runtime'], ' ');}?>"class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="imdb" class="col-4 col-form-label">IMDB Rating</label>
						<div class="col-8">
							<input id="imdb" name="imdb" type="number" value="<?php if(isset($movie_info['imdbRating'])){echo $movie_info['imdbRating'] * 10;}?>" class="form-control">
						</div>
					</div>
					<?php if(isset($movie_info['Ratings'])){
						foreach($movie_info['Ratings'] as $a_rating){
							if($a_rating['Source'] == "Rotten Tomatoes"){
								$tomatometer_score = strtok($a_rating['Value'], '%');
							}
						}
					}
					?>
					<div class="row mb-3">
						<label for="rt_rating" class="col-4 col-form-label">RT Rating</label>
						<div class="col-8">
							<input id="rt_rating" name="rt_rating" type="number" value="<?php if(isset($tomatometer_score)){echo $tomatometer_score;}?>" class="form-control">
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
					<div class="row mb-3">
						<label for="imdbid" class="col-4 col-form-label">IMDB ID</label>
						<div class="col-8">
							<input id="imdbid" name="imdbid" type="text" value="<?php if(isset($movie_info['imdbID'])){echo $movie_info['imdbID'];}?>" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label for="poster" class="col-4 col-form-label">Poster Url</label>
						<div class="col-8">
							<input id="poster" name="poster" type="text" value="<?php if(isset($movie_info['Poster'])){echo $movie_info['Poster'];}?>" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<div class="offset-4 col-8">
							<button name="submit" type="submit" value="addFilm" class="btn btn-primary">Add Film</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-body">
				<p>Search OMDB for information</p>
				<form action="#" method="post">
					<div class="row mb-3">
						<label for="sname" class="col-4 col-form-label">Movie Name</label>
						<div class="col-8">
							<input id="sname" name="sname" type="text" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<div class="offset-4 col-8">
							<button name="submit" type="submit" value="search" class="btn btn-info">Search OMDB</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
	<div class="col-12 col-md-4">
		<div class="card mb-3">
			<div class="card-header">
				Existing Movies <em>(id)</em>
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
