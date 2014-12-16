<?php
namespace includes\core;

/**
 * Description of ResponseEntity
 *
 * @author artyom
 */
class ResponseEntity 
{
	const DEBUG_IN_HEADER = true;

    private $i18n = null;
    private $errors = array();
    private $oks = array();
    private $debugs = array();
    private $result;

    public function __construct(\includes\I18n $i18n)
    {
		$this->i18n = $i18n;
    }
    
    public function addDebug($msg)
    {
		$this->debugs[] = $msg;
    }
    
    public function addError($msg)
    {
		$this->errors[] = $this->i18n->getString($msg);
    }
    
    public function addOk($msg)
    {
		$this->oks[] = $this->i18n->getString($msg);
    }

	public function add(Result $result) {}

	public function setUserCookie($name, $value)
	{
		$this->setCookie($name, $value, false);
	}

	public function setSecureCookie($name, $value)
	{
		$this->setCookie($name, $value, true);
	}

	private function setCookie($name, $value, $secure)
	{
		setcookie($name, $value,  COOKIE_LIVE_TIME, '', '',
				false, (bool)$secure);
	}

	public function send()
	{
		$result = array();

		if (count($this->errors) > 0)
		{
			$result['success'] = false;
			$result['Messages'] = $this->errors;
		}
		elseif (count($this->oks) > 0)
		{
			$result['success'] = true;
			$result['Messages'] = $this->oks;
		}

		if ($this->result instanceof Result)
		{
			$result['data'] = $this->result->getData();
			if ($result->getHttpCode())
			{
				header($result->getHttpCode());
			}
		}

		if (RUN_MODE == DEBUG_MODE && count($this->debugs) > 0)
		{
			if (self::DEBUG_IN_HEADER === true)
			{
				header('DebugInfo: '.json_encode($this->debugs));
			}
			else
			{
				$result['DebugInfo'] = json_encode($this->debugs);
			}
		}

		echo json_encode($result);
	}
}
