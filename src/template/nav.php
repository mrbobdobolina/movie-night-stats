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

	</div>
</header>

<?php if (!is_service_url()): ?>
	<nav class="navbar navbar-dark navbar-expand-lg">
		<div class="container">
			<ul class="navbar-nav row justify-content-between site-navigation">
				<li class="col nav-item">
					<a
						class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">
						<i class="fa-solid fa-calendar-check"></i>
						Events
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item" href="/">
								<i class="fa-solid fa-cards-blank"></i>
								Card View
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="/events/table">
								<i class="fa-solid fa-table"></i>
								Table View
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="/events/rows">
								<i class="fa-solid fa-images"></i>
								Poster View
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="/events/posters">
								<i class="fa-solid fa-image-portrait"></i>
								Winning Poster
							</a>
						</li>
					</ul>

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

		</div>
	</nav>
<?php endif; ?>
