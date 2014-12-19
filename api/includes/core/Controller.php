<?php
namespace includes\core;

use includes\database\MySQLdb;
use includes\User;
use includes\UserDataLoader;
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
	/** @var \StdClass request params from url */
	protected $requestParams = null;
	/** @var \includes\core\Model heirs */
	protected $defaultModel = null;
	/** @var \StdClass with request data */
	protected $data = null;

	public function initVariables(\PDO $db, User $user,
			ResponseEntity $response)
	{
		$this->user = $user;
		$this->db = $db;
		$this->response = $response;
		$this->requestParams = new \StdClass();
	}

	public function setModel(Model $model)
	{
		$this->defaultModel = $model;
	}

	public function setRequestParams(Array $params)
	{
		for ($i = 0, $l = count($params); $i < $l; $i += 2)
		{
			$this->requestParams->$params[$i] = isset($params[$i + 1])
					? $params[$i + 1] : null;
		}
	}

	public function run()
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case self::MTHD_POST:
				$this->data = UserDataLoader::getPostInfo();
				$this->initPost();
				break;
			case self::MTHD_GET:
				$this->data = UserDataLoader::getGetInfo();
				$this->initGet();
				break;
			case self::MTHD_PUT:
				$this->data = UserDataLoader::getPutInfo();
				$this->initPut();
				break;
			case self::MTHD_DELETE:
				$this->data = UserDataLoader::getDeleteInfo();
				$this->initDelete();
				break;
			default:
				throw new \RequestMethodException('Unknown request method');
		}
	}

	public abstract function initPost();
	public abstract function initGet();
	public abstract function initPut();
	public abstract function initDelete();

	/**
	 * use this functions to inject dependency
	 */
	public function preResponse() {}
	public function afterRespone() {}
}