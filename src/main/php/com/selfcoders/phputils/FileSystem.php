<?php
namespace com\selfcoders\phputils;

class FileSystem
{
    /**
     * Format the given size in bytes to a human readable file size.
     *
     * @param int $value The size in bytes
     * @param array $units An array of units
     * @return string The formatted file size (e.g. "100 MB")
     */
    public static function formatFileSize($value, $units = array("B", "KB", "MB", "GB", "TB"))
    {
        return Format::getHumanReadableUnit($value, 1024, $units);
    }
}