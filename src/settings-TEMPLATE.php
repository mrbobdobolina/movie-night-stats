<?php

// Server Timezone
date_default_timezone_set('America/Chicago');

// Movie Night Stats Settings
const ADMIN_PASSWORD = '';
const WEB_ROOT = '';

// Credentials for Main DB
const DB_ADDR = '';
const DB_USER = '';
const DB_PASS = '';
const DB_NAME = '';
const DB_CHAR = 'utf8mb4';
const DB_DSN = "mysql:host=" . DB_ADDR . ";dbname=" . DB_NAME . ";charset=" . DB_CHAR;
const DB_OPTIONS = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => FALSE,
];

// Credentials for Tracking DB
const AT_DB_ENABLED = FALSE;
const AT_DB_ADDR = '';
const AT_DB_USER = '';
const AT_DB_PASS = '';
const AT_DB_NAME = '';

// OMDP API Key
const OMDB_API_KEY = '';
