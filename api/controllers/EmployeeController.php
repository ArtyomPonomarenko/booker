<?php
namespace controllers;

use \includes\core\Controller;
use \includes\Validator;
/**
 * Description of EmployeeController
 *
 * @author aponomarenko
 */
class EmployeeController extends Controller
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
		if (isset($this->requestParams->id))
		{
			if (isset($this->data->name) && $this->validPutData())
			{
					if ($this->defaultModel->updateEmployee(
						$this->requestParams->id, $this->data->name,
						$this->data->email))
				{
					$this->response->addOk('LANG_employee_succesfully_updated');
				}
				else
				{
					$this->response->addError('LANG_cant_create_room');
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

	private function validPutData()
	{
		$valid = true;

		if (!Validator::isWord($this->data->name))
		{

		}

		if (!Validator::isEmail($this->data->email))
		{

		}

		return $valid;
	}

	public function initPost()
	{
		if (isset($this->data->name, $this->data->email)
				&& Validator::isWord($this->data->name)
				&& Validator::isEmail($this->data->email))
		{
			if (($id = $this->defaultModel->insertEmployee($this->data->name, 
					$this->data->email)) !== false)
			{
				$this->response->add(array('EmployeeID' => $id));
				$this->response->addOk('LANG_employee_was_added');
			}
			else
			{
				$this->response->addError('LANG_error_while_add_employee');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_name_and_email');
		}
	}

	public function initGet()
	{
		$employees = array();

		if (isset($this->data->id))
		{
			if ($empInfo =$this->defaultModel->getEmployeeOnce($this->data->id))
			{
				$employees[] = $empInfo;
			}
		}
		else
		{
			$employees = $this->defaultModel->getEmployees();
		}

		if (count($employees))
		{
			$this->response->add($employees);
		}
		else
		{
			$this->response->addError('LANG_cant_find_employees');
		}
	}

	public function initDelete()
	{
		if (isset($this->data->id))
		{
			if ($this->defaultModel->removeEmployee($this->data->id))
			{
				$this->response->addOk('LANG_employee_succefully_removed');
			}
			else
			{
				$this->response->addError('LANG_error_while_delete_employee');
			}
		}
		else
		{
			$this->response->addError('LANG_need_specify_id');
		}
	}
}