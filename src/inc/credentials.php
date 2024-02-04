<?php

function is_admin(): bool {
	return password_verify($_SESSION['password'] ?? '', ADMIN_PASSWORD);
}
