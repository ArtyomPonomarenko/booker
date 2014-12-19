<?php
namespace models;

/**
 * Description of LoginModel
 *
 * @author aponomarenko
 */
class LoginModel extends \includes\core\Model
{
	/** @var array hash-table with user's info */
	private $userInfoCache = array();

	/** @var \PDO */
	private $dbManager = null;

	public function __construct(\PDO $dbManager)
	{
		$this->dbManager = $dbManager;
	}

	/**
	 * @param type $email
	 * @param type $password
	 * @return boolean
	 */
	public function validLogin($email, $password)
	{
		if (($sth = $this->dbManager->prepare("select * from USERS "
				. " where email = ? and password = PASSWORD(?)")) !== false)
		{
			if ($sth->execute(array($email, $password)) && $sth->rowCount() > 0)
			{
				$this->userInfoCache[$email] = $sth->fetch();
				return true;
			}
		}

		return false;
	}

	/**
	 *
	 * @param type $email
	 * @return boolean
	 */
	public function updateLastLogin($email)
	{
		return $this->dbManager->exec("update USERS set LastLogin = NOW()"
				. " where email = '$email' limit 1") > 0;
	}

	public function getUserInfo($email)
	{
		if (isset($this->userInfoCache[$email]))
		{
			return $this->userInfoCache[$email];
		}

		return $this->userInfoCache[$email] = $this->loadUserInfo($email);
	}

	public function getPass($email)
	{
		if (isset($this->userInfoCache[$email]))
		{
			return $this->userInfoCache[$email]['Password'];
		}

		$this->userInfoCache[$email] = $this->loadUserInfo($email);

		return $this->userInfoCache[$email]['Password'];
	}

	private function loadUserInfo($email)
	{
		$result = array();

		if (($sth = $this->dbManager->prepare("select * from USERS "
				. " where email = ?")) !== false)
		{
			if ($sth->execute(array($email)) && $sth->rowCount() > 0)
			{
				$result = $sth->fetch();
			}
		}

		return $result;
	}
}