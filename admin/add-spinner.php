<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');

?>
<div class="album py-5 bg-light">
  <div class="container">
		<p class="display-6 text-center mb-5">Add a Spinner.</p>
    <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">

			<div class="card-body">
				<p>Really?</p>
			</div>
			<div class="card-body">
				<form action="as.php" method="post">
				  <div class="form-group row">
				    <label for="name" class="col-4 col-form-label">Spinner Name</label>
				    <div class="col-8">
				      <input id="name" name="name" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 1</label>
				    <div class="col-8">
				      <input id="color_1" name="color_1" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 2" class="col-4 col-form-label">Color 2</label>
				    <div class="col-8">
				      <input id="color_2" name="color_2" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 3" class="col-4 col-form-label">Color 3</label>
				    <div class="col-8">
				      <input id="color_3" name="color_3" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color " class="col-4 col-form-label">Color 4</label>
				    <div class="col-8">
				      <input id="color_4" name="color_4" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 5</label>
				    <div class="col-8">
				      <input id="color_5" name="color_5" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 6</label>
				    <div class="col-8">
				      <input id="color_6" name="color_6" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 7</label>
				    <div class="col-8">
				      <input id="color_7" name="color_7" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 8</label>
				    <div class="col-8">
				      <input id="color_8" name="color_8" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 9</label>
				    <div class="col-8">
				      <input id="color_9" name="color_9" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 10</label>
				    <div class="col-8">
				      <input id="color_10" name="color_10" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 11</label>
				    <div class="col-8">
				      <input id="color_11" name="color_11" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color 1" class="col-4 col-form-label">Color 12</label>
				    <div class="col-8">
				      <input id="color_12" name="color_12" type="text" class="form-control">
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
				<?php $viewers = getSelectionTypes();?>
									<ul>
									<?php foreach($viewers as $person):?>
										<li><?php echo $person;?></li>
									<?php endforeach;?>
								</ul>
			</div>

			</div>

  </div>
</div>
<?php

include('template/footer.php')

?>
