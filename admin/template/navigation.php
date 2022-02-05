<div class="navbar navbar-dark bg-red shadow-sm">
	<div class="container d-flex justify-content-between">
		<?php

		if(is_admin()):

		?>
			<a href="add-list.php" class="nav-link text-white fw-bold">Scribe's List</a>
			<a href="add-viewer.php" class="nav-link text-white fw-bold">Add Viewer</a>
			<a href="add-movie.php" class="nav-link text-white fw-bold">Add Movie</a>
			<a href="add-game.php" class="nav-link text-white fw-bold">Add Week</a>
			<a href="add-service.php" class="nav-link text-white fw-bold">Add Service</a>
			<a href="add-spinner.php" class="nav-link text-white fw-bold">Add Spinner</a>
			<a href="log-out.php" class="nav-link text-white fw-bold">Log Out</a>
		<?php

		endif;

		?>
	</div>
</div>
