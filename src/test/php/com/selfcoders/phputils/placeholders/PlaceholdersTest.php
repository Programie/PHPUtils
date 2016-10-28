<?php
namespace com\selfcoders\phputils\placeholders;

use PHPUnit_Framework_TestCase;

class PlaceholdersTest extends PHPUnit_Framework_TestCase
{
    public function testSingle()
    {
        $placeholders = new Placeholders;

        $placeholders->append(new Placeholder("word", "world"));

        $this->assertEquals("Hello world", $placeholders->replace("Hello {{word}}"));
    }

    public function testMultiple()
    {
        $placeholders = new Placeholders;

        $placeholders->append(new Placeholder("word", "string"));
        $placeholders->append(new Placeholder("firstWord", "This"));

        $this->assertEquals("This is a longer string", $placeholders->replace("{{firstWord}} is a longer {{word}}"));
    }

    public function testGetValueForPlaceholder()
    {
        $placeholders = new Placeholders;

        $placeholders->append(new Placeholder("foo", "bar"));
        $placeholders->append(new Placeholder("hello", "world"));

        $this->assertEquals("bar", $placeholders->getValueForPlaceholder("foo"));
        $this->assertEquals("world", $placeholders->getValueForPlaceholder("hello"));
    }

    public function testGetPlaceholder()
    {
        $fooPlaceholder = new Placeholder("foo", "bar");
        $helloPlaceholder = new Placeholder("hello", "world");

        $placeholders = new Placeholders;

        $placeholders->append($fooPlaceholder);
        $placeholders->append($helloPlaceholder);

        $this->assertEquals($fooPlaceholder, $placeholders->getPlaceholder("foo"));
        $this->assertEquals($helloPlaceholder, $placeholders->getPlaceholder("hello"));
    }

    /**
     * @expectedException \com\selfcoders\phputils\placeholders\exception\UndefinedPlaceholderException
     */
    public function testUndefinedPlaceholder()
    {
        $placeholders = new Placeholders;

        $placeholders->append(new Placeholder("foo", "bar"));

        $placeholders->replace("foo {{bar}}");
    }
}