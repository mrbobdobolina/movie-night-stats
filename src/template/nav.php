<header>
	<div class="bg-red shadow-sm ">
		<div class="container d-flex header-image text-center" style="height:233px;">
			<a href="/">
				<img src="images/MovieNightStats_v02B_Rectangle_Transparent.png" class="img-fluid">
			</a>
		</div>
		<div class="container d-flex flex-wrap justify-content-between">
			<a href="/" class="nav-link text-white fw-bold"><i class="fa-solid fa-calendar-check"></i> Events</a>
			<a href="/attendance" class="nav-link text-white fw-bold"><i class="fa-solid fa-users"></i> Attendance</a>
			<a href="/wheel" class="nav-link text-white fw-bold"><i class="fa-solid fa-arrows-spin"></i> Spins</a>
			<a href="/movies" class="nav-link text-white fw-bold"><i class="fa-solid fa-film"></i> Movies</a>
			<a href="/services" class="nav-link text-white fw-bold"><i class="fa-solid fa-projector"></i> Services</a>
			<a href="/viewers" class="nav-link text-white fw-bold"><i class="fa-solid fa-face-grin-stars"></i> Viewers</a>
			<a href="/years" class="nav-link text-white fw-bold"><i class="fa-solid fa-calendar-days"></i> Years</a>
		</div>
		<?php
		$page_array = Array('event_table.php', 'event_rows.php', 'event_posters.php');
		if(in_array(basename($_SERVER['PHP_SELF']),$page_array)):?>
			<div class="container d-flex flex-wrap justify-content-start">
				<span class="nav-link text-white fw-bold">View Options:</span>
				<a href="/" class="nav-link text-white fw-bold"><i class="fa-solid fa-cards-blank"></i> Normal View</a>
				<a href="/event_table" class="nav-link text-white fw-bold"><i class="fa-solid fa-table"></i> Table View</a>
				<a href="/event_rows" class="nav-link text-white fw-bold"><i class="fa-solid fa-images"></i> Poster View</a>
				<a href="/event_posters" class="nav-link text-white fw-bold"><i class="fa-solid fa-image-portrait"></i> Winning Posters</a>
			</div>
		<?php endif; ?>
	</div>
</header>
