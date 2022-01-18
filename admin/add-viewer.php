<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');

?>
<div class="album py-5 bg-light">
  <div class="container">
		<p class="display-6 text-center mb-5">Add a viewer.</p>
    <div class="row row-cols-1 row-cols-md-2 row-cols-md-2 row-cols-xl-3 g-3">

			<div class="card-body">
				<p>Congrats on your new friend, I guess.</p>
			</div>
			<div class="card-body">
				<form action="av.php" method="post">
				  <div class="form-group row">
				    <label for="name" class="col-4 col-form-label">Viewer Name</label>
				    <div class="col-8">
				      <input id="name" name="name" type="text" class="form-control">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="color" class="col-4 col-form-label">Color</label>
				    <div class="col-8">
				      <input id="color" name="color" type="text" class="form-control">
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
				<?php $viewers = getListOfViewers();?>
									<ul>
									<?php foreach($viewers as $person):?>
										<li><?php echo $person['name'];?></li>
									<?php endforeach;?>
								</ul>
			</div>

			</div>

  </div>
</div>

<?php

include('template/footer.php')

?>
