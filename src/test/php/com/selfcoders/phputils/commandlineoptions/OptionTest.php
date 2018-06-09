<?php
namespace com\selfcoders\phputils\commandlineoptions;

use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    public function testParseKeyValue()
    {
        $option = new Option("--myoption=myvalue");

        $this->assertEquals("--myoption", $option->name);
        $this->assertEquals("myvalue", $option->value);
    }

    public function testParseValue()
    {
        $option = new Option("some value");

        $this->assertNull($option->name);
        $this->assertEquals("some value", $option->value);
    }

    public function testParseQuotedKeyValue()
    {
        $option = new Option("--myoption=\"my quoted value\"");

        $this->assertEquals("--myoption", $option->name);
        $this->assertEquals("my quoted value", $option->value);
    }

    public function testParseQuotedValue()
    {
        $option = new Option("\"my quoted value\"");

        $this->assertNull($option->name);
        $this->assertEquals("my quoted value", $option->value);
    }
}