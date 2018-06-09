<?php
namespace com\selfcoders\phputils;

use PHPUnit\Framework\TestCase;

class HTTPTest extends TestCase
{
    public function testParseHeader()
    {
        $content = implode("\r\n", array
        (
            "HTTP/1.1 200 OK",
            "Date: Tue, 13 Jan 2015 18:03:55 GMT",
            "Expires: -1",
            "Cache-Control: private, max-age=0",
            "Content-Type: text/html; charset=ISO-8859-1",
            "Set-Cookie: myCookie=myValue=1; expires=Thu, 12-Jan-2017 18:03:55 GMT; path=/; domain=.example.com; secure",
            "Set-Cookie: myOtherCookie=another value; expires=Wed, 15-Jul-2015 18:03:55 GMT; path=/; domain=.example.com; HttpOnly",
            "Server: Apache"
        ));

        $headerLowerCase = HTTP::parseHeader($content, true);

        $this->assertTrue(isset($headerLowerCase[0]->cookies["mycookie"]));
        $this->assertTrue(isset($headerLowerCase[0]->headers["date"]));

        $header = HTTP::parseHeader($content);

        $this->assertInternalType("array", $header[0]->cookies);
        $this->assertInternalType("array", $header[0]->headers);

        $this->assertEquals("1.1", $header[0]->version);
        $this->assertEquals(200, $header[0]->statusCode);
        $this->assertEquals("OK", $header[0]->statusText);

        /**
         * @var HTTPCookie $myCookie
         */
        $myCookie = $header[0]->cookies["myCookie"];

        $this->assertEquals("myCookie", $myCookie->name);
        $this->assertEquals("myValue=1", $myCookie->value);
        $this->assertEquals("Thu, 12-Jan-2017 18:03:55 GMT", $myCookie->expires);
        $this->assertEquals(".example.com", $myCookie->domain);
        $this->assertTrue($myCookie->secure);

        /**
         * @var HTTPCookie $myOtherCookie
         */
        $myOtherCookie = $header[0]->cookies["myOtherCookie"];

        $this->assertEquals("myOtherCookie", $myOtherCookie->name);
        $this->assertEquals("another value", $myOtherCookie->value);
        $this->assertEquals("Wed, 15-Jul-2015 18:03:55 GMT", $myOtherCookie->expires);
        $this->assertEquals(".example.com", $myOtherCookie->domain);
        $this->assertFalse($myOtherCookie->secure);

        // Test some header fields
        $this->assertEquals("Tue, 13 Jan 2015 18:03:55 GMT", $header[0]->headers["Date"]);
        $this->assertEquals("-1", $header[0]->headers["Expires"]);
        $this->assertEquals("private, max-age=0", $header[0]->headers["Cache-Control"]);
        $this->assertEquals("text/html; charset=ISO-8859-1", $header[0]->headers["Content-Type"]);
        $this->assertEquals("Apache", $header[0]->headers["Server"]);
        $this->assertFalse(isset($header[0]->headers["Set-Cookie"]));// Set-Cookie field should not exist (it's parsed into the cookies array)

        $this->assertFalse(isset($header[1]));
    }

    public function testParseMultipleHeaders()
    {
        $content = implode("\r\n", array
        (
            "HTTP/1.1 301 Moved Permanently",
            "Date: Tue, 13 Jan 2015 18:03:53 GMT",
            "Server: Apache",
            "Location: https://example.com",
            "",
            "HTTP/1.1 302 Found",
            "Date: Tue, 13 Jan 2015 18:03:54 GMT",
            "Server: Apache",
            "Location: https://example.com/some-other-location",
            "",
            "HTTP/1.1 200 OK",
            "Date: Tue, 13 Jan 2015 18:03:55 GMT",
            "Expires: -1",
            "Cache-Control: private, max-age=0",
            "Content-Type: text/html; charset=ISO-8859-1",
            "Set-Cookie: myCookie=myValue=1; expires=Thu, 12-Jan-2017 18:03:55 GMT; path=/; domain=.example.com; secure",
            "Set-Cookie: myOtherCookie=another value; expires=Wed, 15-Jul-2015 18:03:55 GMT; path=/; domain=.example.com; HttpOnly",
            "Server: Apache"
        ));

        $header = HTTP::parseHeader($content, true);

        $this->assertEquals("Tue, 13 Jan 2015 18:03:53 GMT", $header[0]->headers["date"]);
        $this->assertEquals("Tue, 13 Jan 2015 18:03:54 GMT", $header[1]->headers["date"]);
        $this->assertEquals("Tue, 13 Jan 2015 18:03:55 GMT", $header[2]->headers["date"]);

        $this->assertEquals("1.1", $header[0]->version);
        $this->assertEquals(301, $header[0]->statusCode);
        $this->assertEquals("Moved Permanently", $header[0]->statusText);

        $this->assertEquals("1.1", $header[1]->version);
        $this->assertEquals(302, $header[1]->statusCode);
        $this->assertEquals("Found", $header[1]->statusText);

        $this->assertEquals("1.1", $header[2]->version);
        $this->assertEquals(200, $header[2]->statusCode);
        $this->assertEquals("OK", $header[2]->statusText);

        $this->assertFalse(isset($header[3]));
    }

    public function testParseHeadersProxy()
    {
        $content = implode("\r\n", array
        (
            "HTTP/1.0 200 Connection established",
            "",
            "HTTP/1.1 301 Moved Permanently",
            "Date: Tue, 13 Jan 2015 18:03:53 GMT",
            "Server: Apache",
            "Location: https://example.com",
            "",
            "HTTP/1.1 302 Found",
            "Date: Tue, 13 Jan 2015 18:03:54 GMT",
            "Server: Apache",
            "Location: https://example.com/some-other-location",
            "",
            "HTTP/1.1 200 OK",
            "Date: Tue, 13 Jan 2015 18:03:55 GMT",
            "Expires: -1",
            "Cache-Control: private, max-age=0",
            "Content-Type: text/html; charset=ISO-8859-1",
            "Set-Cookie: myCookie=myValue=1; expires=Thu, 12-Jan-2017 18:03:55 GMT; path=/; domain=.example.com; secure",
            "Set-Cookie: myOtherCookie=another value; expires=Wed, 15-Jul-2015 18:03:55 GMT; path=/; domain=.example.com; HttpOnly",
            "Server: Apache"
        ));

        $header = HTTP::parseHeader($content, true);

        $this->assertTrue(empty($header[0]->headers));
        $this->assertTrue(empty($header[0]->cookies));

        $this->assertEquals("1.0", $header[0]->version);
        $this->assertEquals(200, $header[0]->statusCode);
        $this->assertEquals("Connection established", $header[0]->statusText);

        $this->assertEquals("Tue, 13 Jan 2015 18:03:53 GMT", $header[1]->headers["date"]);
        $this->assertEquals("Tue, 13 Jan 2015 18:03:54 GMT", $header[2]->headers["date"]);
        $this->assertEquals("Tue, 13 Jan 2015 18:03:55 GMT", $header[3]->headers["date"]);

        $this->assertEquals("1.1", $header[1]->version);
        $this->assertEquals(301, $header[1]->statusCode);
        $this->assertEquals("Moved Permanently", $header[1]->statusText);

        $this->assertEquals("1.1", $header[2]->version);
        $this->assertEquals(302, $header[2]->statusCode);
        $this->assertEquals("Found", $header[2]->statusText);

        $this->assertEquals("1.1", $header[3]->version);
        $this->assertEquals(200, $header[3]->statusCode);
        $this->assertEquals("OK", $header[3]->statusText);

        $this->assertFalse(isset($header[4]));
    }
}