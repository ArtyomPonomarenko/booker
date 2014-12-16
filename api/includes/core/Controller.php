<?php
namespace includes\core;

use includes\database\MySQLdb;
use includes\User;

/**
 * Description of Controller
 *
 * @author aponomarenko
 */
abstract class Controller
{
	const MTHD_POST = 'POST';
	const MTHD_GET = 'GET';
	const MTHD_PUT = 'PUT';
	const MTHD_DELETE = 'DELETE';

	/** @var \includes\User current user */
	protected $user = null;
	/** @var \PDO booker db */
	protected $db = null;
	/** @var \includes\core\ResponseEntity */
	protected $response = null;

	public function initVariables(\PDO $db, User $user,
			ResponseEntity $response)
	{
		$this->user = $user;
		$this->db = $db;
		$this->response = $response;
	}

	protected function getRequestMethod()
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case self::MTHD_POST:
				return self::MTHD_POST;
			case self::MTHD_GET:
				return self::MTHD_GET;
			case self::MTHD_PUT:
				return self::MTHD_PUT;
			case self::MTHD_DELETE:
				return self::MTHD_DELETE;
			default:
				throw new \RequestMethodException('Unknown request method');
		}
	}

	/**
	 * use this functions to inject dependency
	 */
	public function preResponse() {}
	public function afterRespone() {}

	public abstract function run();
}