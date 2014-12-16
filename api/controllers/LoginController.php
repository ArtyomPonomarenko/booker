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
	public function run()
	{
		if (parent::MTHD_PUT != $this->getRequestMethod())
		{
			throw new \RequestMethodException('Login use only PUT method');
		}

		$putData = UserDataLoader::getPutInfo();

		if (!isset($putData->login, $putData->password))
		{
			throw new \InvalidParamException('login and password is needed'
					. ' to login');
		}

		$model = new \models\LoginModel($this->db);

		if ($model->validLogin($putData->login, $putData->password))
		{
			$userInfo = $model->getUserInfo($putData->login);
			$this->response->setUserCookie('UserInfo',
				json_encode($userInfo));
			$this->response->setSecureCookie('LoginInfo', $putData->login . '::'
					. $model->getPass($putData->login));
			$model->updateLastLogin($userInfo['Email']);
		}
		else
		{
			$this->response->addError('LANG_invalid_user_password');
		}
	}
}