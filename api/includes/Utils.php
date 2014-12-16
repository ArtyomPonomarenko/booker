<?php
namespace includes;

/**
 * Description of Utils
 *
 * @author artyom
 */
class Utils 
{
    private $bookerDb = null;
    
    public function __construct(\includes\Database\MySQLdb $db)
    {
	$this->bookerDb = $db;
    }
    
    public function getAuthCard()
    {
	
    }
}
