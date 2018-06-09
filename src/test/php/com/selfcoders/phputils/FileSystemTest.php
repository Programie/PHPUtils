<?php
namespace com\selfcoders\phputils;

use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{
    public function testFormatFileSize()
    {
        $this->assertEquals("1023 B", FileSystem::formatFileSize(1023));
        $this->assertEquals("123 KB", FileSystem::formatFileSize(1024 * 123));
        $this->assertEquals("2.5 MB", FileSystem::formatFileSize(1024 * 1024 * 2.5));
        $this->assertEquals("1 GB", FileSystem::formatFileSize(1024 * 1024 * 1024));
        $this->assertEquals("5 TB", FileSystem::formatFileSize(1024 * 1024 * 1024 * 1024 * 5));
        $this->assertEquals("1024 TB", FileSystem::formatFileSize(1024 * 1024 * 1024 * 1024 * 1024));
        $this->assertEquals("2048 TB", FileSystem::formatFileSize(1024 * 1024 * 1024 * 1024 * 1024 * 2));
    }
}