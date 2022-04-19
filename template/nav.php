<header>
	<div class="bg-red shadow-sm ">
		<div class="container d-flex header-image text-center" style="height:233px;">
			<a href="index.php">
				<img src="images/MovieNightStats_v02B_Rectangle_Transparent.png" class="img-fluid">
			</a>
		</div>
		<div class="container d-flex flex-wrap justify-content-between">
			<a href="index.php" class="nav-link text-white fw-bold">Events</a>
			<a href="attendance.php" class="nav-link text-white fw-bold">Attendance</a>
			<a href="wheel.php" class="nav-link text-white fw-bold">Spins</a>
			<a href="movies.php" class="nav-link text-white fw-bold">Movies</a>
			<a href="services.php" class="nav-link text-white fw-bold">Services</a>
			<a href="viewers.php" class="nav-link text-white fw-bold">Viewers</a>
			<a href="years.php" class="nav-link text-white fw-bold">Years</a>
		</div>
		<?php
		$page_array = Array('event_table.php', 'event_rows.php', 'event_posters.php');
		if(in_array(basename($_SERVER['PHP_SELF']),$page_array)):?>
			<div class="container d-flex flex-wrap justify-content-start">
				<span class="nav-link text-white fw-bold">View Options:</span>
				<a href="index.php" class="nav-link text-white fw-bold">Normal View</a>
				<a href="event_table.php" class="nav-link text-white fw-bold">Table View</a>
				<a href="event_rows.php" class="nav-link text-white fw-bold">Poster View</a>
				<a href="event_posters.php" class="nav-link text-white fw-bold">Winning Posters</a>
			</div>
		<?php endif; ?>
	</div>
</header>
