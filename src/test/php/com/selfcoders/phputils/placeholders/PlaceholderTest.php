<?php
namespace com\selfcoders\phputils\placeholders;

use PHPUnit_Framework_TestCase;

class PlaceholderTest extends PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $this->assertTrue(Placeholder::validate("FOO"));
        $this->assertTrue(Placeholder::validate("bar"));
        $this->assertTrue(Placeholder::validate("fooBar"));
        $this->assertTrue(Placeholder::validate("foo-bar"));
        $this->assertTrue(Placeholder::validate("foo_bar"));
        $this->assertFalse(Placeholder::validate("foo+bar"));
        $this->assertFalse(Placeholder::validate("foo~bar"));
        $this->assertFalse(Placeholder::validate("Foo!Bar"));
    }
}