<?php
//PDO instantiation
try {
	$pdo = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
}
catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
