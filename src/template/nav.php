<header>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-auto">
				<a href="/">
					<img
						src="/images/MovieNightStats_v02B_Rectangle_Transparent.png"
						class="site-logo"
						alt="Movie Night Stats">
				</a>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg">
			<ul class="navbar-nav row justify-content-between site-navigation">
				<li class="col nav-item">
					<a href="/" class="nav-link fw-bold">
						<i class="fa-solid fa-calendar-check"></i>
						Events
					</a>
				</li>
				<li class="col nav-item">
					<a href="/attendance" class="nav-link">
						<i class="fa-solid fa-users"></i>
						Attendance
					</a>
				</li>
				<li class="col nav-item">
					<a href="/spins" class="nav-link">
						<i class="fa-solid fa-arrows-spin"></i>
						Spins
					</a>
				</li>
				<li class="col nav-item">
					<a href="/movies" class="nav-link">
						<i class="fa-solid fa-film"></i>
						Movies
					</a>
				</li>
				<li class="col nav-item">
					<a href="/services" class="nav-link">
						<i class="fa-solid fa-projector"></i>
						Services
					</a>
				</li>
				<li class="col nav-item">
					<a href="/viewer/list" class="nav-link">
						<i class="fa-solid fa-face-grin-stars"></i>
						Viewers
					</a>
				</li>
				<li class="col nav-item">
					<a href="/years" class="nav-link">
						<i class="fa-solid fa-calendar-days"></i>
						Years
					</a>
				</li>
			</ul>


		</nav>
	</div>
	<?php
	$page_array = [ 'events/table', 'events/rows', 'events/posters' ];
	if (in_array($_GET['url'] ?? '', $page_array)):?>
		<div class="container d-flex flex-wrap justify-content-start">
			<span class="nav-link text-white fw-bold">View Options:</span>
			<a href="/" class="nav-link text-white fw-bold"><i class="fa-solid fa-cards-blank"></i> Normal View</a>
			<a href="/events/table" class="nav-link text-white fw-bold"><i class="fa-solid fa-table"></i> Table View</a>
			<a href="/events/rows" class="nav-link text-white fw-bold"><i class="fa-solid fa-images"></i> Poster
				View</a>
			<a href="/events/posters" class="nav-link text-white fw-bold"><i class="fa-solid fa-image-portrait"></i>
				Winning Posters</a>
		</div>
	<?php endif; ?>
</header>
