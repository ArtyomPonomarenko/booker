<?php
namespace models;

/**
 * Description of EmployeeModel
 *
 * @author aponomarenko
 */
class EmployeeModel
{
	public function getEmployeeOnce($id)
	{
		$result = array();
		if (($sth = $this->dbManager->prepare("select Email,Name from EMPLOYEES"
				. " where id = ? limit 1")) !== false)
		{
			if ($sth->execute(array($id)) && $sth->rowCount() > 0)
			{
				$result = $sth->fetch();
			}
		}

		return $result;
	}

	public function getEmployees()
	{
		$result = array();
		if (($rows = $this->dbManager->exec("select Id,Name,Email from "
				. "EMPLOYEES")) !== false)
		{
			foreach ($rows as $row)
			{
				$result[] = $row;
			}
		}

		return $result;
	}

	public function removeEmployee($id)
	{
		if (($sth = $this->dbManager->prepare("delete EMPLOYEES es"
				. " inner join EVENTSDATA ed on ed.EmployeeId = es.Id"
				. " inner join EVENTS e on e.DataId = ed.Id where es.Id = ?"))
				!== false)
		{
			if ($sth->execute(array($id)) && $sth->rowCount() > 0)
			{
				return true;
			}
		}

		return false;
	}

	public function insertEmployee($name, $email)
	{
		if (($sth = $this->dbManager->prepare("insert into EMPLOYEES set"
				. " Name = ?, Email = ?")) !== false)
		{
			if ($sth->execute(array($name, $email)))
			{
				return $this->dbManager->lastInsertId();
			}
		}

		return false;
	}

	public function updateEmployee($id, $name, $email)
	{
		if (($sth = $this->dbManager->prepare("update EMPLOYEES set Name = ?,"
				. " Email = ? where Id = ? limit 1")) !== false)
		{
			if ($sth->execute(array($name, $email, $id))
					&& $sth->rowCount() > 0)
			{
				return true;
			}
		}

		return false;
	}
}