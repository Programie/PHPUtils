<?php
namespace com\selfcoders\phputils;

class Format
{
	/**
	 * Convert the specified number into a human readable unit.
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

	/**
	 * Convert the given number of seconds into a human readable format.
	 *
	 * @param int $seconds The seconds to convert
	 *
	 * @return string A string in format "hh:ii:ss", "x day hh:ii:ss" or "x days hh:ii:ss"
	 */
	public static function formatTime($seconds)
	{
		$days = floor($seconds / 60 / 60 / 24);
		$seconds -= $days * 60 * 60 * 24;

		$hours = floor($seconds / 60 / 60);
		$seconds -= $hours * 60 * 60;

		$minutes = floor($seconds / 60);
		$seconds -= $minutes * 60;

		$string = "";

		if ($days)
		{
			if ($days == 1)
			{
				$string .= "1 day";
			}
			else
			{
				$string .= $days . " days";
			}

			$string .= " ";
		}

		$string .= implode(":", array
		(
			str_pad($hours, 2, "0", STR_PAD_LEFT),
			str_pad($minutes, 2, "0", STR_PAD_LEFT),
			str_pad($seconds, 2, "0", STR_PAD_LEFT)
		));

		return $string;
	}
}