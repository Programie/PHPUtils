<?php
namespace com\selfcoders\phputils;

use PHPUnit_Framework_TestCase;

class URLTest extends PHPUnit_Framework_TestCase
{
    public function testBuildFullUrl()
    {
        $this->assertEquals("http://user:password@example.com/path/to/some/file?q1=123&q2=test#hash", URL::buildUrl(parse_url("http://user:password@example.com/path/to/some/file?q1=123&q2=test#hash")));
    }

    public function testBuildUsernameUrl()
    {
        $this->assertEquals("http://user@example.com/path/to/some/file", URL::buildUrl(parse_url("http://user@example.com/path/to/some/file")));
    }

    public function testBuildUsernamePasswordUrl()
    {
        $this->assertEquals("http://user:password@example.com/path/to/some/file", URL::buildUrl(parse_url("http://user:password@example.com/path/to/some/file")));
    }

    public function testBuildFileUrl()
    {
        $this->assertEquals("file:///var/log/syslog", URL::buildUrl(parse_url("file:///var/log/syslog")));
    }

    public function testBuildHttpsUrl()
    {
        $this->assertEquals("https://example.com", URL::buildUrl(parse_url("https://example.com")));
    }

    public function testBuildNoPathQueryUrl()
    {
        $this->assertEquals("http://example.com?a=b", URL::buildUrl(parse_url("http://example.com?a=b")));
    }

    public function testBuildNoPathFragmentUrl()
    {
        $this->assertEquals("http://example.com#hash", URL::buildUrl(parse_url("http://example.com#hash")));
    }

    public function testBuildCustomScheme()
    {
        $this->assertEquals("custom://example.com:8000", URL::buildUrl(parse_url("custom://example.com:8000")));
    }

    public function testGetRootUrl()
    {
        $this->assertEquals("https://example.com", URL::getRootUrl());
    }
}