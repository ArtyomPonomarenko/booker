<?php
include_once __DIR__ . '/includes/config.php';

if (RUN_MODE == DEBUG_MODE)
{
    ini_set('display_errors', 'on');
    error_reporting(-1);
}
else
{
    error_reporting(0);
}
include_once __DIR__ . '/includes/AutoLoader.php';
spl_autoload_register(array('includes\AutoLoader', 'loadDefaults'));

$i18n = new \includes\I18n();
$response = new \includes\core\ResponseEntity($i18n);

try
{
	$bookerDb = \includes\database\DBFactory::getBookerDb();
}
catch (\DBException $e)
{
	$response->addDebug($e->getMessage());
	$response->addError('LANG_no_access');
	$response->send();
	exit(); //no db connection no api, sorry :(
}

$user = new \includes\User($bookerDb, $i18n);//@TODO Utils::getUser($db, $i18n); @return User | GuestUser

$router = new \includes\core\Router($user, $response, $bookerDb);

$url = PROTOCOL . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$router->handle($url);

$router->sendResponse();

#$response->send(); ????