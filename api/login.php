<?php
if ('PUT' === $_SERVER['REQUEST_METHOD'])
{
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
	$bookerDb = \includes\database\MySQLdb::getBookerDb();
}
catch (\DBException $e)
{
	$response->addDebug($e->getMessage());
	$response->addError('LANG_no_access');
	$response->send();
	exit(); //no db connection no api, sorry :(
}



}