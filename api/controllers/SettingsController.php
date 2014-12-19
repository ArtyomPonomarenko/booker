<?php
namespace controllers;

use \includes\core\Controller;
/**
 * Description of SettingsController
 *
 * @author aponomarenko
 */
class SettingsController extends Controller
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

	}

	public function initDelete()
	{

	}
}