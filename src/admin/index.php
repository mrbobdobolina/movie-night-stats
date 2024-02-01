<?php

require_once( "../common.php" );

include( 'inc/credentials.php' );

if (is_admin()) {
	header('Location: ' . WEB_ROOT . '/admin/add-game.php');
}

if (!empty($_POST)) {
	if (!empty($_POST['password'])) {
		// Simple delay to stop bots
		// TODO: Set up login monitor and ban IPs
		if ($_POST['password'] == ADMIN_PASSWORD) {
			$p_hash = password_hash(ADMIN_PASSWORD, PASSWORD_BCRYPT);
			setcookie('password', $p_hash, time() + 60 * 60 * 24 * 365);
			header('Location: ' . WEB_ROOT . '/admin/add-game.php');
		}
		else {
			sleep(10);
			$alert = [
				'color' => 'danger',
				'msg'   => 'Error! Incorrect Password.',
			];
		}
	}
	else {
		$alert = [
			'color' => 'danger',
			'msg'   => 'Error! You need to enter a password to log in.',
		];
	}
}


include( 'template/header.php' );

?>
<h1 class="display-6 text-center">You should probably login or whatever</h1>
<div class="text-center mb-5"></div>

<?php

if (!empty($alert)) {
	echo '<div class="alert alert-' . $alert['color'] . ' alert-dismissible fade show" role="alert">';
	echo $alert['msg'];
	echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
	echo '</div>';
}

?>

<div class="row justify-content-center">
	<div class="col-12 col-md-8 col-lg-6 col-xl-5">

		<form action="#" method="post">
			<div class="card">
				<div class="card-body">

					<div class="row">
						<div class="col mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" name="password" class="form-control" id="password">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>

				</div>
			</div>
		</form>

	</div>
</div>
<?php

include( 'template/footer.php' )

?>
