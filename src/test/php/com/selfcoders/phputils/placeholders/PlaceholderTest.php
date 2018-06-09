<?php
namespace com\selfcoders\phputils\placeholders;

use PHPUnit\Framework\TestCase;

class PlaceholderTest extends TestCase
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