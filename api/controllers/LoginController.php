<?php
namespace controllers;

use includes\core\Controller;
use includes\UserDataLoader;
/**
 * Description of LoginController
 *
 * @author aponomarenko
 */
class LoginController extends Controller
{
	public function initPut()
	{
		if (!isset($this->data->login, $this->data->password))
		{
			throw new \InvalidParamException('login and password is needed'
					. ' to login');
		}

		$this->defaultModel = new \models\LoginModel($this->db);

		if ($this->defaultModel->validLogin($this->data->login,
				$this->data->password))
		{
			$userInfo = $this->defaultModel->getUserInfo($this->data->login);
			$this->response->setUserCookie('UserInfo',
				json_encode($userInfo));
			$this->response->setSecureCookie('LoginInfo', $this->data->login
					. '::' . $this->defaultModel->getPass($this->data->login));
			$this->defaultModel->updateLastLogin($userInfo['Email']);
			$this->response->addOk('LANG_login_succesfull');
		}
		else
		{
			$this->response->addError('LANG_invalid_user_password');
		}
	}

	public function initPost()
	{
		throw new \RequestMethodException('Login use only PUT method');
	}

	public function initDelete()
	{
		throw new \RequestMethodException('Login use only PUT method');
	}

	public function initGet()
	{
		throw new \RequestMethodException('Login use only PUT method');
	}
}