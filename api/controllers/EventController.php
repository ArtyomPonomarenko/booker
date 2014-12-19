<?php
namespace controllers;

use \includes\core\Controller;
use includes\User;
use includes\core\ResponseEntity;
use \includes\Validator;
/**
 * Description of EventController
 *
 * @author aponomarenko
 */
class EventController extends Controller
{
	public function preResponse()
	{
		if (!$this->user->authenticate())
		{
			throw new \AcessDeniedException('Authorize use only');
		}
	}

	public function initPut()
	{

	}

	public function initPost()
	{
		
	}

	public function initGet()
	{
		if (isset($this->data->start, $this->data->end))
		{
			if (Validator::isValidDateRange($this->data->start,
					$this->data->end))
			{
				#@todo do stuff
			}
			else
			{
				$this->response->addError('LANG_invalid_date_range');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_start_end');
		}
	}

	public function initDelete()
	{

	}
}