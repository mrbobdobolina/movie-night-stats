<?php

if(file_exists(ROOT.'/settings.php')){
	header('Location: '.WEB_ROOT.'/');
	die();
}

$alert = FALSE;

if (!empty($_POST['submit'])) {
	try {
		do_required_fields_have_values();
		are_db_credentials_valid();
		write_settings_file();
		header('Location: ./db.php');
	}
	catch (Exception $exception) {
		$alert = $exception->getMessage();
	}
}

/**
 * @throws Exception
 */
function do_required_fields_have_values(): bool {
	if (empty($_POST['admin-password'])) {
		throw new Exception('Please set an admin password for Movie Night Stats');
	}
	if (empty($_POST['db-addr'])) {
		throw new Exception('Please specify an address to connect to the database');
	}
	if (empty($_POST['db-name'])) {
		throw new Exception('Please specify a database to use for the installation');
	}
	if (empty($_POST['db-username'])) {
		throw new Exception('Please set the username to use to connect to the database');
	}
	if (empty($_POST['db-password'])) {
		throw new Exception('Please set a password to use to connect to the database');
	}

	return TRUE;
}

/**
 * @throws Exception
 */
function are_db_credentials_valid(): true|string {
	try {
		$mysqli = new mysqli($_POST['db-addr'], $_POST['db-username'], $_POST['db-password'], $_POST['db-name']);
		if ($mysqli->connect_errno) {
			throw new Exception('Connect failed: ' . $mysqli->connect_error);
		}

	}
	catch (Exception $exception) {
		$message = $exception->getMessage();
		if (str_starts_with($message, 'php_network_getaddresses: getaddrinfo')) {
			throw new Exception('Unable to find MySQL server. Did you enter the correct address?');
		}
		if (str_starts_with($message, 'Access denied')) {
			throw new Exception('Access Denied. Please check the username and password.');
		}
		if(str_starts_with($message, 'Unknown database')){
			throw new Exception('Could not find the chosen database. Please make sure it has already been created');
		}
		throw new Exception($message);
	}

	return TRUE;
}


/**
 * @throws Exception
 */
function write_settings_file(): void {
	$hashed_password = '';
	try {
		$hashed_password = password_hash($_POST['admin-password'], PASSWORD_ARGON2ID);
	}
	catch (Exception $error) {
		$hashed_password = password_hash($_POST['admin-password'], PASSWORD_DEFAULT);
	}

	$settings = '<' . "?php\n";

	$settings .= "\n// Server Timezone\n";
	$settings .= "date_default_timezone_set('America/Chicago');\n";

	$settings .= "\n// Movie Night Stats Settings\n";
	$settings .= "const ADMIN_PASSWORD = '{$hashed_password}';\n";
	$settings .= "const WEB_ROOT = '{$_POST['web-root']}';\n";

	$settings .= "\n// Credentials for Main DB\n";
	$settings .= "const DB_ADDR = '{$_POST['db-addr']}';\n";
	$settings .= "const DB_USER = '{$_POST['db-username']}';\n";
	$settings .= "const DB_PASS = '{$_POST['db-password']}';\n";
	$settings .= "const DB_NAME = '{$_POST['db-name']}';\n";

	$settings .= "const DB_CHAR = 'utf8mb4';\n";
	$settings .= "const DB_DSN = 'mysql:host={$_POST['db-addr']};dbname={$_POST['db-name']};charset=utf8mb4';\n";
	$settings .= "const DB_OPTIONS = [\n\tPDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,\n\tPDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,\n\tPDO::ATTR_EMULATE_PREPARES => FALSE\n];\n";

	$settings .= "\n// Credentials for Tracking DB\n";
	$settings .= "const AT_DB_ENABLED = FALSE;\n";
	$settings .= "const AT_DB_ADDR = '{$_POST['db-addr']}';\n";
	$settings .= "const AT_DB_USER = '{$_POST['db-username']}';\n";
	$settings .= "const AT_DB_PASS = '{$_POST['db-password']}';\n";
	$settings .= "const AT_DB_NAME = '{$_POST['db-name']}';\n";

	echo ROOT . '/settings.php';

	file_put_contents(ROOT . '/settings.php', $settings);
}

?>

<main class="container my-3">
	<h1>Create Settings File</h1>
	<?php

	if ($alert) {
		echo '<div class="alert alert-danger" role="alert">' . $alert . '</div>';
	}

	?>
	<form action="#" method="POST" class="row">
		<div class="col-12 mt-3">
			<h4>Movie Night Stats Settings</h4>
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="mns-admin-password" class="form-label">Admin Page Password</label>
			<input
				id="mns-admin-password" name="admin-password" type="password" class="form-control"
				value="<?php echo $_POST['admin-password'] ?? ''; ?>">
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="web-root" class="form-label">Base URL</label>
			<input
				type="text" id="web-root" name="web-root" class="form-control"
				value="<?php echo $_POST['web-root'] ?? ''; ?>">
			<div class="form-text">
				Leave blank if installed in root directory
			</div>
		</div>

		<div class="col-12 my-3">
			<h4>Database Settings</h4>
			Make sure the database has been created before proceeding
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="db-addr" class="form-label">Address</label>
			<input
				type="text" id="db-addr" class="form-control" name="db-addr"
				value="<?php echo $_POST['db-addr'] ?? ''; ?>">
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="db-name" class="form-label">Database</label>
			<input
				type="text" id="db-name" class="form-control" name="db-name"
				value="<?php echo $_POST['db-name'] ?? ''; ?>">
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="db-username" class="form-label">Username</label>
			<input
				type="text" id="db-username" class="form-control" name="db-username"
				value="<?php echo $_POST['db-username'] ?? ''; ?>">
		</div>
		<div class="col-12 col-sm-6 mb-3">
			<label for="db-password" class="form-label">Password</label>
			<input
				type="password" id="db-password" class="form-control" name="db-password"
				value="<?php echo $_POST['db-password'] ?? ''; ?>">
		</div>
		<div class="col-12 my-3">
			<input type="submit" name="submit" value="Save" class="btn btn-primary form-control">
		</div>
	</form>
</main>
