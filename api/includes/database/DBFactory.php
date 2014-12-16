<?php
namespace includes\database;

/**
 * Description of DBFactory
 *
 * @author aponomarenko
 */
class DBFactory
{
	/** @var \PDO singletone instance for booker database */
	private static $bookerInstance = null;

	/**
	 * get singletone instance
	 * @return \PDO
	 */
	public static function getBookerDb()
	{
		if (self::$bookerInstance instanceof \PDO)
		{
			return self::$bookerInstance;
		}

		return self::$bookerInstance = self::createDbInstance(DB_HOST, DB_USER,
				OS_USER_PASS, OS_DB_NAME);
	}

	private static function createDbInstance($host, $user, $pass, $dbName)
    {
		$dsn = 'mysql:dbname=' . $dbName . ';host=' . $host;

		try
		{
			return new \PDO($dsn, $user, $pass/*, $options = array()*/);
		}
		catch (\PDOException $ex)
		{
			throw new \DBException('Cant connect to database', 0, $ex);
		}
    }
}