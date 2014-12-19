<?php
namespace controllers;

use includes\core\Controller;
use includes\Validator;
/**
 * Description of RoomController
 *
 * @author aponomarenko
 */
class RoomController extends Controller
{
	public function preResponse()
	{
		if (!$this->user->authenticate())
		{
			throw new \AcessDeniedException('Authorize use only');
		}
	}

	public function initGet()
	{
		$rooms = array();
		if (isset($this->data->id))
		{
			if ($roomInfo = $this->defaultModel->getRoomOnce($this->data->id))
			{
				$rooms[] = $roomInfo;
			}
		}
		else
		{
			$rooms = $this->defaultModel->getAllRooms();
		}

		if (count($rooms))
		{
			$this->response->add($rooms);
		}
		else
		{
			$this->response->addError('LANG_cant_find_rooms');
		}
	}

	public function initPut()
	{
		$this->checkAdmin();

		if (isset($this->requestParams->id))
		{
			if (isset($this->data->name)
					&& Validator::isWord($this->data->name))
			{
				if ($this->defaultModel->updateRoom($this->requestParams->id,
						$this->data->name))
				{
					$this->response->addOk('LANG_room_succesfully_updated');
				}
				else
				{
					$this->response->addError('LANG_cant_update_room');
				}
			}
			else
			{
				$this->resonse->addError('LANG_invalid_name');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_id');
		}
	}

	public function initPost()
	{
		$this->checkAdmin();

		if (isset($this->data->name) && Validator::isWord($this->data->name))
		{
			if (($id = $this->defaultModel->insertRoom($this->data->name))
					!== false)
			{
				$this->response->add(array('RoomID' => $id));
				$this->response->addOk('LANG_room_was_added');
			}
			else
			{
				$this->response->addError('LANG_error_while_add_room');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_name');
		}
	}

	public function initDelete()
	{
		$this->checkAdmin();

		if (isset($this->data->id))
		{
			if ($this->defaultModel->removeRoom($this->data->id))
			{
				$this->response->addOk('LANG_room_succefully_removed');
			}
			else
			{
				$this->response->addError('LANG_error_while_delete_room');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_id');
		}
	}

	private function checkAdmin()
	{
		if (!$this->user->isAdmin())
		{
			throw new \AcessDeniedException('Admin user only');
		}
	}
}