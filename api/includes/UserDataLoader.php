<?php
namespace includes;

/**
 * Description of UserDataLoader
 *
 * @author artyom
 */
class UserDataLoader 
{
    /**
     * load cookie info
     * @global array $_COOKIE
     * @return \stdClass
     */
    public static function getUserCookies()
    {
		global $_COOKIE;
	
		return self::hanlde($_COOKIE);
    }

	/**
     * load post info
     * @global array $_POST
     * @return \stdClass
     */
	public static function getPostInfo()
	{
		global $_POST;

		return self::hanlde($_POST);
	}

	/**
     * load put info
     * @return \stdClass
     */
	public static function getPutInfo()
	{
		parse_str($_SERVER['QUERY_STRING'], $put);
		return self::hanlde($put);
	}

	/**
     * load delete info
     * @return \stdClass
     */
	public static function getDeleteInfo()
	{
		parse_str(file_get_contents('php://input'), $delete);
		return self::hanlde($delete);
	}

	/**
     * load get info
     * @global array $_GET
     * @return \stdClass
     */
	public static function getGetInfo()
	{
		global $_GET;
	
		return self::hanlde($_GET);
	}

	/**
	 * @param array $data
	 * @return \stdClass with data
	 */
	private static function hanlde(array $data)
	{
		$result = new \StdClass();
		foreach  ($data as $key => $value)
		{
			 $result->$key = (is_array($value)) ? self::handle($value) : $value;
		}

		return $result;
	}
}
