<?php
/**
 * Description of Service
 *
 * @author aponomarenko
 */
abstract class Model
{
	/**
	 * must return includes\core\Result
	 */
	public abstract function getData($url);
}