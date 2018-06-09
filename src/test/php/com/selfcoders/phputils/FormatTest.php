<?php
namespace com\selfcoders\phputils;

use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testGetHumanReadableUnit()
    {
        $units = array("A", "B", "C");
        $factor = 10;

        $this->assertEquals("1 A", Format::getHumanReadableUnit(1, $factor, $units));
        $this->assertEquals("1 B", Format::getHumanReadableUnit(10, $factor, $units));
        $this->assertEquals("1 C", Format::getHumanReadableUnit(10 * 10, $factor, $units));
        $this->assertEquals("10 C", Format::getHumanReadableUnit(10 * 10 * 10, $factor, $units));
    }

    public function testFormatTime()
    {
        $this->assertEquals("05:34:12", Format::formatTime(20052));
        $this->assertEquals("1 day 12:45:32", Format::formatTime(132332));
        $this->assertEquals("2 days 21:32:34", Format::formatTime(250354));
    }
}