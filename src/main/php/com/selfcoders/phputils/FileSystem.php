<?php
namespace com\selfcoders\phputils;

class FileSystem
{
	public static function formatFileSize($value)
	{
		return Format::getHumanReadableUnit($value, 1024, $units = array("B", "KB", "MB", "GB", "TB"));
	}
}