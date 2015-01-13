<?php
namespace com\selfcoders\phputils;

class Format
{
	/**
	 * Convert the specified number into a human readable unit
	 *
	 * @param int $value The value to convert
	 * @param array $units An array of units to use
	 * @param int $factor The factor to use for each unit
	 *
	 * @return string The value in format"<Value> <Unit> (e.g. 100 MB)
	 */
	public static function getHumanReadableUnit($value, $factor, $units)
	{
		$value = (int) abs($value);

		foreach ($units as $index => $unit)
		{
			if ($value < $factor || $index == count($units) - 1)
			{
				return round($value, 2) . " " . $unit;
			}
			$value /= $factor;
		}

		return "";
	}
}