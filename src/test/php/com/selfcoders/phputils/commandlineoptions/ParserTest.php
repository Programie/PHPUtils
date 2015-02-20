<?php
namespace com\selfcoders\phputils\commandlineoptions;

class ParserTest extends \PHPUnit_Framework_TestCase
{
	public function testGetOptions()
	{
		$parser = new Parser("--myoption=value -a=123 -a=test --another-option=this-is-a-test --spaced-option=\"my value\" \"value without option\"");

		$this->assertNull($parser->getOption("--invalid-option"));
		$this->assertNull($parser->getOption("--myoption", 1));

		$this->assertEquals("value", $parser->getOption("--myoption", 0)->value);

		$options = $parser->getOption("-a");
		$this->assertEquals("123", $options[0]->value);
		$this->assertEquals("test", $options[1]->value);

		$this->assertEquals("this-is-a-test", $parser->getOption("--another-option")[0]->value);

		$this->assertEquals("my value", $parser->getOption("--spaced-option", 0)->value);

		$this->assertEquals("value without option", $parser->getOption("", 0)->value);

		$this->assertInternalType(\PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $parser->getOptions());
		$this->assertInternalType(\PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $parser->getOptions()["-a"]);
		$this->assertInstanceOf("com\\selfcoders\\phputils\\commandlineoptions\\Option", $parser->getOptions()["-a"][0]);
	}
}