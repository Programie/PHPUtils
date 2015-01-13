<?php
namespace com\selfcoders\phputils;

class FormatTest extends \PHPUnit_Framework_TestCase
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

	public function testGetHumanReadableUnitNonEmpty()
	{
		$this->assertNotEquals("", Format::getHumanReadableUnit(10000000000, 10, array("A")));
	}
}