<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');

?>
<div class="album py-5 bg-light">
  <div class="container">
		<p class="display-6 text-center mb-5">Add a movie.</p>
    <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">

			<div class="card-body">
				<p>Kinda feels like you already have enough of those...</p>
			</div>
			<div class="card-body">
				<form action="am.php" method="post">
				  <div class="form-group row mb-1">
				    <label for="name" class="col-4 col-form-label">Movie Name</label>
				    <div class="col-8">
				      <input id="name" name="name" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-1">
				    <label for="year" class="col-4 col-form-label">Movie Year</label>
				    <div class="col-8">
				      <input id="year" name="year" type="number" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-2">
				    <label for="runtime" class="col-4 col-form-label">Movie Runtime</label>
				    <div class="col-8">
				      <input id="runtime" name="runtime" type="number" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-1">
				    <label for="imdb" class="col-4 col-form-label">IMDB Rating</label>
				    <div class="col-8">
				      <input id="imdb" name="imdb" type="number" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-1">
				    <label for="rt_rating" class="col-4 col-form-label">RT Rating</label>
				    <div class="col-8">
				      <input id="rt_rating" name="rt_rating" type="number" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-1">
				    <label for="rta_rating" class="col-4 col-form-label">RT Audience Rating</label>
				    <div class="col-8">
				      <input id="rta_rating" name="rta_rating" type="number" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row mb-1">
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
			<div class="card-body">
				<?php $viewers = getMovieList();?>
									<ul>
									<?php foreach($viewers as $person):?>
										<li><?php echo $person['name'];?> <em>(<?php echo $person['id'];?>)</em></li>
									<?php endforeach;?>
								</ul>
			</div>

			</div>

  </div>
</div>
<?php

include('template/footer.php')

?>
