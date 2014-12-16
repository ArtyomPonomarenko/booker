<?php
namespace includes;

/**
 * Description of AutoLoader
 *
 * @author artyom
 */
class AutoLoader 
{
    /**
     * 
     * @param type $className
     */
    public static function loadDefaults($className) 
    {
		if (preg_match('/^.*Exception$/', $className))
		{
			include BASE_ROOT . '/includes/exceptions/' . $className . '.php';
			return;
		}

		$path = str_replace('\\', '/', $className);
	
		if (file_exists(BASE_ROOT . '/' . $path . '.php'))
		{
			include BASE_ROOT . '/' . $path . '.php';
		}
    }
}
