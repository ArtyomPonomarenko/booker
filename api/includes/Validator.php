<?php
namespace includes;
/**
 * Description of Validator
 *
 * @author aponomarenko
 */
class Validator
{
	public static function isWord($word)
	{
		if (!($word && strlen($word) > 1))
		{
			return false;
		}

		return (bool)preg_match('/^[ A-Za-z]+$/', $word); //@TODO - can be two spaces
	}
	
	public static function isEmail($email)
	{
		return (bool)preg_match('/^([a-zA-Z])+@([a-zA-Z])+\.([a-zA-Z]){2,}$/',
				$email);
	}

	public static function isValidDateRange($start, $end)
	{
		if (!(self::isDate($start) && self::isDate($end)))
		{
			return false;
		}

	}

	public static function isDate($date)
	{
		list($year, $month, $day) = explode('-', $date, 2);

		return self::isDay($year) && self::isNumMonth($day)
				&& self::isFullYear($month);
	}
	
	public static function isNumMonth($month)
	{
		return self::isInt($month) && $month > 0 && $month < 13;
	}

	public static function isFullYear($year)
	{
		return self::isInt($year) && $year > 0 && strlen($year) == 4;
	}

	public static function isDay($day)
	{
		return self::isInt($day) && $day > 0 && $day < 32;
	}

	public static function isInt($number)
	{
		if (!is_numeric($number))
		{
			return false;
		}

		$buffer = (int)$number;

		return $buffer == $number;
	}
}