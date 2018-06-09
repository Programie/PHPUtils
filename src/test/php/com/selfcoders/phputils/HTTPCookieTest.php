<?php
namespace com\selfcoders\phputils;

use PHPUnit\Framework\TestCase;

class HTTPCookieTest extends TestCase
{
    public function testParse()
    {
        $cookie = new HTTPCookie();

        $cookie->parse("myCookie=myValue=1; expires=Thu, 12-Jan-2017 18:03:55 GMT; path=/; domain=.example.com; secure");

        $this->assertEquals("myCookie", $cookie->name);
        $this->assertEquals("myValue=1", $cookie->value);
        $this->assertEquals("/", $cookie->path);
        $this->assertEquals(".example.com", $cookie->domain);
        $this->assertEquals("Thu, 12-Jan-2017 18:03:55 GMT", $cookie->expires);
        $this->assertTrue($cookie->secure);
    }
}