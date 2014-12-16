<?php
namespace controllers;

use \includes\core\Controller;
use includes\database\MySQLdb;
use includes\User;
use includes\core\ResponseEntity;
/**
 * Description of EventController
 *
 * @author aponomarenko
 */
class EventController extends Controller
{
	public function __construct(MySQLdb $db, User $user,
			ResponseEntity $response)
	{
		if (!$user->authenticate())
		{
			throw new \AcessDeniedException('Event section authorized use '
					. 'only');
		}

		parent::initVariables($db, $user, $response);
	}
	
	public function run()
	{

	}
}