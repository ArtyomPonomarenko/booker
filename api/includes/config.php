<?php
define('BASE_ROOT', __DIR__ . '/..');

#run mods
define('DEBUG_MODE', 'debug');
define('PRODUCTION_MODE', 'production');
define('RUN_MODE', DEBUG_MODE); //should be DEBUG_MODE or PRODUCTION_MODE

#database
//define('DB_HOST', 'localhost');
//define('DB_USER', 'bookerApi');
//define('OS_USER_PASS', 'temp123');
//define('OS_DB_NAME', 'BOOKER');

define('DB_HOST', 'sql5.freemysqlhosting.net');
define('DB_USER', 'sql561018');
define('OS_USER_PASS', 'fA6%hX8*'); //???
define('OS_DB_NAME', 'sql561018');

define('LOGS_FILE', BASE_ROOT . '/logFile');
define('PROTOCOL', ('443' === $_SERVER['SERVER_PORT']) ? 'https' : 'http');

define('COOKIE_LIVE_TIME', time() + 60 * 60 * 24 * 10); //10 days

define('BASE_URL', '/booker_dev/api/');