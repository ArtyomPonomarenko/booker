<?php
namespace includes\core;

use \includes\User;

/**
 * serves as router between high-level models
 *
 * @author artyom
 */
class Router
{
	/** @var \PDO db entity */
	private $db = null;
	/** @var \includes\core\ResponseEntity */
	private $response = null;
	/** @var \includes\User booker's user entity */
	private $user = null;

	/** @var Controller controller heir */
	private $controller = null;

    public function __construct(User $user, ResponseEntity $response,
			\PDO $db)
	{

		$this->db = $db;
		$this->response = $response;
		$this->user = $user;
	}

	public function handle($url)
	{
		$parsedUrl = parse_url($url);
		
		$controllerName = str_replace(BASE_URL, '', $parsedUrl['path']);
		$fullContollerName = '\\controllers\\' 
			. ucfirst(ucfirst(strtolower($controllerName))) . 'Controller';

		if (!class_exists($fullContollerName, true))
		{
			$this->response->addDebug($controllerName);
			$this->response->addError('LANG_wrong_api_function');
			return;
		}

		try
		{
			$this->controller = new $fullContollerName();
			$this->controller->initVariables($this->db, $this->user,
					$this->response);

			$this->controller->preResponse();

			$this->controller->run();

		}
		catch (\AcessDeniedException $ex)
		{
			$this->response->addDebug($ex->getMessage());
			$this->response->addError('LANG_no_access');
		}
		catch (\InvalidParamException $ex)
		{
			$this->response->addDebug($ex->getMessage());
			$this->response->addError('LANG_invalid_parameters');
		}
		catch (\RequestMethodException $ex)
		{
			$this->response->addDebug($ex->getMessage());
			$this->response->addError('LANG_invalid_method');
		}
		catch (\Exception $ex)
		{
			$this->response->addDebug($ex->getMessage());
			$this->response->addDebug('Uncaught exception! File:'
					. $ex->getFile() . ' Line:' . $ex->getLine());
			$this->response->addError('LANG_error_while_handle_request');
			#handle, bad programmer((
		}

		#...... other exceptions
	}

	public function sendResponse()
	{
		$this->response->send();

		if ($this->controller instanceof Controller)
		{
			$this->controller->afterRespone();
		}
	}
}
