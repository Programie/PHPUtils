<?php
namespace com\selfcoders\phputils;

class URLTest extends \PHPUnit_Framework_TestCase
{
	public function testFullParseBuildUrl()
	{
		$this->assertEquals("http://user:password@example.com/path/to/some/file?q1=123&q2=test#hash", URL::buildUrl(parse_url("http://user:password@example.com/path/to/some/file?q1=123&q2=test#hash")));
	}

	public function testNoAuthParseBuildUrl()
	{
		$this->assertEquals("http://example.com/path/to/some/file?q1=123&q2=test#hash", URL::buildUrl(parse_url("http://example.com/path/to/some/file?q1=123&q2=test#hash")));
	}
}