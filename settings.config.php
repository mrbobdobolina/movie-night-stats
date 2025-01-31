<?php

// Server Timezone
date_default_timezone_set('America/Chicago');

// Admin Password
define('ADMIN_PASSWORD', 'PhilipWins');

//OMDP API Key
define('OMDB_API_KEY', 'cad1c81e');

//DB credentials for the main database
define('DB_ADDR', 'movie-night-stats-db');
define('DB_USER', 'apathday_movie');
define('DB_PASS', 'z=Da=&-C.y~0I?)x=F');
define('DB_NAME', 'apathday_movie_night_stats');
define('DB_CHAR', 'utf8mb4');
define('DB_DSN', "mysql:host=".DB_ADDR.";dbname=".DB_NAME.";charset=".DB_CHAR);
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);
