<?php
namespace com\selfcoders\phputils;

class HTTPTest extends \PHPUnit_Framework_TestCase
{
	public function testParseHeader()
	{
		$content = array
		(
			"HTTP/1.1 200 OK",
			"Date: Tue, 13 Jan 2015 18:03:55 GMT",
			"Expires: -1",
			"Cache-Control: private, max-age=0",
			"Content-Type: text/html; charset=ISO-8859-1",
			"Set-Cookie: myCookie=myValue=1; expires=Thu, 12-Jan-2017 18:03:55 GMT; path=/; domain=.example.com; secure",
			"Set-Cookie: myOtherCookie=another value; expires=Wed, 15-Jul-2015 18:03:55 GMT; path=/; domain=.example.com; HttpOnly",
			"Server: Apache"
		);

		$header = HTTP::parseHeader(implode("\r\n", $content));

		$this->assertInternalType("array", $header->cookies);
		$this->assertInternalType("array", $header->headers);

		/**
		 * @var HTTPCookie $myCookie
		 */
		$myCookie = $header->cookies["myCookie"];

		$this->assertEquals("myCookie", $myCookie->name);
		$this->assertEquals("myValue=1", $myCookie->value);
		$this->assertEquals("Thu, 12-Jan-2017 18:03:55 GMT", $myCookie->expires);
		$this->assertEquals(".example.com", $myCookie->domain);
		$this->assertTrue($myCookie->secure);

		/**
		 * @var HTTPCookie $myOtherCookie
		 */
		$myOtherCookie = $header->cookies["myOtherCookie"];

		$this->assertEquals("myOtherCookie", $myOtherCookie->name);
		$this->assertEquals("another value", $myOtherCookie->value);
		$this->assertEquals("Wed, 15-Jul-2015 18:03:55 GMT", $myOtherCookie->expires);
		$this->assertEquals(".example.com", $myOtherCookie->domain);
		$this->assertFalse($myOtherCookie->secure);

		// Test some header fields
		$this->assertEquals("Tue, 13 Jan 2015 18:03:55 GMT", $header->headers["Date"]);
		$this->assertEquals("-1", $header->headers["Expires"]);
		$this->assertEquals("private, max-age=0", $header->headers["Cache-Control"]);
		$this->assertEquals("text/html; charset=ISO-8859-1", $header->headers["Content-Type"]);
		$this->assertEquals("Apache", $header->headers["Server"]);
		$this->assertFalse(isset($header->headers["Set-Cookie"]));// Set-Cookie field should not exist (it's parsed into the cookies array)
	}
}