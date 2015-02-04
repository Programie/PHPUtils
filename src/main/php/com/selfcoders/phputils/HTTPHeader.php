<?php
namespace com\selfcoders\phputils;

class HTTPHeader
{
	/**
	 * @var array An array of HTTPCookie instances
	 */
	public $cookies;
	/**
	 * @var array An array of header fields
	 */
	public $headers;
	/**
	 * @var string The HTTP version (e.g. 1.0 or 1.1)
	 */
	public $version;
	/**
	 * @var int The status code (e.g. 200, 301 or 500)
	 */
	public $statusCode;
}