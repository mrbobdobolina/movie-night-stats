<?php

$navigation_links = [];

if (!is_service_url()) {
	$navigation_links[] = [
		'link'     => '#',
		'text'     => '<i class="fa-solid fa-calendar-check"></i> Events',
		'dropdown' => [
			[
				'link' => WEB_ROOT . '/',
				'text' => '<i class="fa-solid fa-cards-blank"></i> Card View',
			],
			[
				'link' => WEB_ROOT . '/events/table',
				'text' => '<i class="fa-solid fa-table"></i> Table View',
			],
			[
				'link' => WEB_ROOT . '/events/rows',
				'text' => '<i class="fa-solid fa-images"></i> Poster View',
			],
			[
				'link' => WEB_ROOT . '/events/posters',
				'text' => '<i class="fa-solid fa-image-portrait"></i> Winning Poster',
			],
		],
	];
	$navigation_links[] = [
		'link' => WEB_ROOT . '/attendance',
		'text' => '<i class="fa-solid fa-users"></i> Attendance',
	];
	$navigation_links[] = [
		'link' => WEB_ROOT . '/spins',
		'text' => '<i class="fa-solid fa-arrows-spin"></i> Spins',
	];
	$navigation_links[] = [
		'link' => WEB_ROOT . '/movies',
		'text' => '<i class="fa-solid fa-film"></i> Movies',
	];
	$navigation_links[] = [
		'link' => '/services',
		'text' => WEB_ROOT . '<i class="fa-solid fa-projector"></i> Services',
	];
	$navigation_links[] = [
		'link' => WEB_ROOT . '/viewer/list',
		'text' => '<i class="fa-solid fa-face-grin-stars"></i> Viewers',
	];
	$navigation_links[] = [
		'link' => WEB_ROOT . '/years',
		'text' => '<i class="fa-solid fa-calendar-days"></i> Years',
	];
}

?>

<header class="navbar navbar-expand-xl sticky-top shadow">
	<nav class="container">
		<a href="<?php echo is_service_url() ? '#' : WEB_ROOT.'/'; ?>" class="navbar-brand">
			<img
				alt="Movie Night Stats"
				src="/images/MovieNightStats_v02B_Rectangle_Transparent.png">
		</a>

		<?php if(!empty($navigation_links)): ?>

			<button
				class="navbar-toggler text-end"
				type="button"
				data-bs-toggle="collapse"
				data-bs-target="#site-navigation-collapse"
				aria-controls="site-navigation-collapse"
				aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="site-navigation-collapse">
				<ul class="navbar-nav navbar-nav-scroll row justify-content-between">
					<?php

					foreach ($navigation_links as $element) {
						echo '<li class="col-auto nav-item">';

						if (!empty($element['dropdown'])) {
							echo '<a href="' . $element['link'] . '" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
						}
						else {
							echo '<a href="' . $element['link'] . '" class="nav-link">';
						}

						echo $element['text'];
						echo '</a>';

						if (!empty($element['dropdown'])) {
							echo '<ul class="dropdown-menu shadow">';

							foreach($element['dropdown'] as $sub_element){
								echo '<li><a class="dropdown-item" href="'.$sub_element['link'].'">';
								echo $sub_element['text'];
								echo '</a></li>';
							}

							echo '</ul>';
						}


						echo '</li>';
					}

					?>
				</ul>
			</div>

		<?php endif; ?>

	</nav>
</header>
