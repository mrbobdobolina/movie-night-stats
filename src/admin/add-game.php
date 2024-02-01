<?php

require_once( "../common.php" );

include( 'inc/credentials.php' );

restrict_page_to_admin();

include( 'template/header.php' );


if (!empty($_POST)) {
	// Update the first and last instances for all the movies
	for ($i = 1; $i <= 12; $i++) {
		$query = sprintf(
			"UPDATE `films` SET `first_instance`='%s' WHERE `id`='%d' AND `first_instance` IS NULL",
			db_esc($_POST['date'] ?? '1970-01-01'),
			$_POST['wedge_' . $i] ?? 0
		);
		db($query);

		$query = sprintf(
			"UPDATE `films` SET `last_instance`='%s' WHERE `id`='%d' AND (`last_instance` IS NULL OR `last_instance` <= '%s')",
			db_esc($_POST['date'] ?? '1970-01-01'),
			$_POST['wedge_' . $i] ?? 0,
			db_esc($_POST['date'] ?? '1970-01-01'),
		);
		db($query);
	}

	// Update Attendance
	foreach ($_POST['attendees'] ?? [] as $person) {
		$query = sprintf(
			"UPDATE `viewers` SET `attendance`=`attendance`+1 WHERE `id`='%d'",
			$person ?? 0
		);
		db($query);
	}

	// Update Spinners
	$query = sprintf(
		"UPDATE `spinners` SET `uses`=`uses`+1 WHERE `name`='%s'",
		db_esc($_POST['selection_method'] ?? '')
	);
	db($query);

	// Update Week DB
	$query = sprintf(
		"INSERT INTO `week` SET `date`='%s', " .
		"`wheel_1`='%d', `wheel_2`='%d', `wheel_3`='%d', `wheel_4`='%d', `wheel_5`='%d', `wheel_6`='%d', " .
		"`wheel_7`='%d', `wheel_8`='%d', `wheel_9`='%d', `wheel_10`='%d', `wheel_11`='%d', `wheel_12`='%d', " .
		"`moviegoer_1`='%d', `moviegoer_2`='%d', `moviegoer_3`='%d', `moviegoer_4`='%d', `moviegoer_5`='%d', `moviegoer_6`='%d', " .
		"`moviegoer_7`='%d', `moviegoer_8`='%d', `moviegoer_9`='%d', `moviegoer_10`='%d', `moviegoer_11`='%d', `moviegoer_12`='%d', " .
		"`spinner`='%d', `winning_wedge`='%d', `winning_film`='%d', " .
		"`format`='%s', `error_spin`='%s', `scribe`='%s', `theme`='%s', `attendees`='%s', `selection_method`='%s', `runtime`='%s', `winning_moviegoer`='%s'",

		db_esc($_POST['date'] ?? '1970-01-01'),

		db_esc($_POST['wedge_1'] ?? 0),
		db_esc($_POST['wedge_2'] ?? 0),
		db_esc($_POST['wedge_3'] ?? 0),
		db_esc($_POST['wedge_4'] ?? 0),
		db_esc($_POST['wedge_5'] ?? 0),
		db_esc($_POST['wedge_6'] ?? 0),

		db_esc($_POST['wedge_7'] ?? 0),
		db_esc($_POST['wedge_8'] ?? 0),
		db_esc($_POST['wedge_9'] ?? 0),
		db_esc($_POST['wedge_10'] ?? 0),
		db_esc($_POST['wedge_11'] ?? 0),
		db_esc($_POST['wedge_12'] ?? 0),

		db_esc($_POST['viewer_1'] ?? 0),
		db_esc($_POST['viewer_2'] ?? 0),
		db_esc($_POST['viewer_3'] ?? 0),
		db_esc($_POST['viewer_4'] ?? 0),
		db_esc($_POST['viewer_5'] ?? 0),
		db_esc($_POST['viewer_6'] ?? 0),

		db_esc($_POST['viewer_7'] ?? 0),
		db_esc($_POST['viewer_8'] ?? 0),
		db_esc($_POST['viewer_9'] ?? 0),
		db_esc($_POST['viewer_10'] ?? 0),
		db_esc($_POST['viewer_11'] ?? 0),
		db_esc($_POST['viewer_12'] ?? 0),

		db_esc($_POST['spinner'] ?? 0),
		db_esc($_POST['winning_wedge'] ?? 0),
		db_esc($_POST['wedge_' . $_POST['winning_wedge'] ?? 1] ?? 0),

		db_esc($_POST['format'] ?? ''),
		db_esc($_POST['error_spin'] ?? ''),
		db_esc($_POST['scribe'] ?? ''),
		db_esc($_POST['theme'] ?? ''),
		db_esc(implode(', ', $_POST['attendees'] ?? [])),
		db_esc($_POST['selection_method'] ?? ''),
		db_esc($_POST['runtime'] ?? 0),
		db_esc($_POST['viewer_' . $_POST['winning_wedge'] ?? 1] ?? 0)
	);

	db($query);

	$alert = [
		'color' => 'success',
		'msg'   => 'Success! Game added to database!',
	];
}

$movies = get_movie_list($pdo);

$movieSelect = "<option selected></option>";

foreach ($movies as $aFilm) {
	$movieSelect .= "<option value=\"" . $aFilm["id"] . "\">" . $aFilm["name"] . " (" . $aFilm["runtime"] . " min)</option>";
}

$viewers = getListOfViewers();

$viewerSelect = "<option disabled selected></option>";

foreach ($viewers as $aPerson) {
	$viewerSelect .= "<option value=\"" . $aPerson["id"] . "\">" . $aPerson["name"] . "</option>";
}


$selectors = getSelectionTypes(TRUE);

$selectorsSelect = "<option disabled selected></option>";

foreach ($selectors as $aTool) {
	$selectorsSelect .= "<option value=\"" . $aTool . "\">" . $aTool . "</option>";
}

$services = getListOfServices();

$servicesSelect = "<option disabled selected></option>";

foreach ($services as $aService) {
	$servicesSelect .= "<option value=\"" . $aService['name'] . "\">" . $aService['name'] . "</option>";
}

?>
<h1 class="display-6 text-center">Add an Event</h1>
<div class="text-center mb-5"></div>


<?php

if (!empty($alert)) {
	echo '<div class="alert alert-' . $alert['color'] . ' alert-dismissible fade show" role="alert">';
	echo $alert['msg'];
	echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
	echo '</div>';
}

?>
<form action="#" method="POST">
	<div class="row justify-content-center">

		<div class="col-12 col-xxl-6">

			<div class="card mb-3">
				<div class="card-header">Wedges</div>
				<div class="card-body">
					<table class="table" style="table-layout:fixed;">
						<thead>
						<tr>
							<th style="width:15%;min-width:50px;">Wedge #</th>
							<th style="width:50%;">Movie</th>
							<th>Viewer</th>
						</tr>
						</thead>
						<tbody>
						<?php for ($i = 1; $i <= 12; $i++): ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td>
									<select
										class="form-control form-control-sm selectpicker"
										name="wedge_<?php echo $i; ?>"
										id="wedge_<?php echo $i; ?>"
										data-live-search="true"
										data-size="10">
										<?php echo $movieSelect; ?>
									</select>
								</td>
								<td>
									<select
										class="form-select form-select-sm"
										name="viewer_<?php echo $i; ?>"
										id="viewer_<?php echo $i; ?>">
										<?php echo $viewerSelect; ?>
									</select>
								</td>
							</tr>
						<?php endfor; ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>


		<div class="col-12 col-sm-6 col-xxl-3">
			<div class="card mb-3">
				<div class="card-header">
					Metadata
				</div>
				<div class="card-body">
					<div class="row">

						<div class="col-12 mb-3">
							<label class="form-label">Date</label>
							<input
								class="form-control"
								type="date"
								name="date"
								placeholder="yyyy-mm-dd"
								value="<?php echo date("Y-m-d"); ?>">
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Scribe</label>
							<select class="form-select" name="scribe" id="scribe"><?php echo $viewerSelect; ?></select>
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Spinner</label>
							<select class="form-select" name="spinner"><?php echo $viewerSelect; ?>
								<option value="0">Viewer Choice</option>
							</select>
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Selection Method</label>
							<select class="form-select" name="selection_method"><?php echo $selectorsSelect; ?></select>
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Theme</label>
							<input class="form-control" type="text" name="theme">
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Attendees</label>
							<?php foreach ($viewers as $key => $value): ?>
								<div class="form-check">
									<input
										name="attendees[]"
										id="attendees_<?php echo $value['id']; ?>"
										type="checkbox"
										class="check-attendee form-check-input"
										value="<?php echo $value['id']; ?>">
									<label
										for="attendees_<?php echo $value['id']; ?>"
										class="form-check-label"><?php echo $value['name']; ?></label>
								</div>
							<?php endforeach; ?>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-xxl-3">
			<div class="card mb-3">
				<div class="card-header">
					Winner
				</div>
				<div class="card-body">
					<div class="row">

						<div class="col-12 mb-3">
							<label class="form-label">Winning Number: </label>
							<select class="form-select" name="winning_wedge">
								<?php
								for ($i = 1; $i < 13; $i++) {
									echo "<option value='" . $i . "'>" . $i . "</option>";
								} ?>
							</select>
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Error Spin(s)</label>
							<input class="form-control" type="text" name="error_spin">
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Format</label>
							<select class="form-select" name="format"><?php echo $servicesSelect; ?></select>
						</div>

						<div class="col-12 mb-3">
							<label class="form-label">Runtime</label>
							<input class="form-control" type="text" name="runtime">
						</div>

						<div class="col-12 mb-3">
							<input class="btn btn-primary" type="submit" value="Submit">
						</div>

					</div>
				</div>
			</div>
		</div>


	</div>
</form>
<?php

include( 'template/footer.php' )

?>
