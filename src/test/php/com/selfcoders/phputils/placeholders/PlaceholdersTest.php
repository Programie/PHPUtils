<?php
namespace com\selfcoders\phputils\placeholders;

use PHPUnit\Framework\TestCase;

class PlaceholdersTest extends TestCase
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

    public function testGetRecursivePlaceholder()
    {
        $level1Placeholder = new Placeholder("level1", "level1 > {{level2}}");
        $level2Placeholder = new Placeholder("level2", "level2 > {{level3}}");
        $level3Placeholder = new Placeholder("level3", "foobar");

        $placeholders = new Placeholders;

        $placeholders->append($level1Placeholder);
        $placeholders->append($level2Placeholder);
        $placeholders->append($level3Placeholder);

        $string = "level0 > {{level1}}";

        $this->assertEquals("level0 > level1 > {{level2}}", $placeholders->replace($string));
        $this->assertEquals("level0 > level1 > level2 > {{level3}}", $placeholders->replace($string, 1));
        $this->assertEquals("level0 > level1 > level2 > foobar", $placeholders->replace($string, 10));
    }

    public function testGetInfiniteRecursivePlaceholder()
    {
        $placeholder1 = new Placeholder("placeholder1", "placeholder2 is {{placeholder2}}");
        $placeholder2 = new Placeholder("placeholder2", "placeholder1 is {{placeholder1}}");

        $placeholders = new Placeholders;

        $placeholders->append($placeholder1);
        $placeholders->append($placeholder2);

        $expected = "placeholder1 is placeholder2 is placeholder1 is placeholder2 is placeholder1 is {{placeholder1}}";

        $this->assertEquals($expected, $placeholders->replace("placeholder1 is {{placeholder1}}", 3));
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