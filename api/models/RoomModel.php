<?php
namespace models;

/**
 * Description of RoomModel
 *
 * @author aponomarenko
 */
class RoomModel extends \includes\core\Model
{
	/** @var \PDO */
	private $dbManager = null;

	public function insertRoom($name)
	{
		if (($sth = $this->dbManager->prepare("insert into ROOMS set Name = ?")) 
				!== false)
		{
			if ($sth->execute(array($name)))
			{
				return $this->dbManager->lastInsertId();
			}
		}
		
		return false;
	}

	public function getRoomOnce($id)
	{
		$result = array();
		if (($sth = $this->dbManager->prepare("select Name from ROOMS "
				. " where id = ? limit 1")) !== false)
		{
			if ($sth->execute(array($id)) && $sth->rowCount() > 0)
			{
				$result = $sth->fetch();
			}
		}
		
		return $result;
	}

	public function getAllRooms()
	{
		$result = array();
		if (($rows = $this->dbManager->exec("select Id,Name from ROOMS "))
				!== false)
		{
			foreach ($rows as $row)
			{
				$result[] = $row;
			}
		}

		return $result;
	}

	public function removeRoom($id)
	{
		if (($sth = $this->dbManager->prepare("delete ROOMS r" 
				. " inner join EVENTSDATA ed on ed.RoomId = r.Id" 
				. " inner join EVENTS e on e.DataId = ed.Id where r.id = ?"))
				!== false)
		{
			if ($sth->execute(array($id)) && $sth->rowCount() > 0)
			{
				return true;
			}
		}

		return false;
	}
	
	public function updateRoom($id, $name)
	{
		if (($sth = $this->dbManager->prepare("update ROOMS set Name = ?"
				. " where Id = ? limit 1")) !== false)
		{
			if ($sth->execute(array($name, $id)) && $sth->rowCount() > 0)
			{
				return true;
			}
		}

		return false;
	}
}