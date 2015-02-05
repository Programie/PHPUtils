<?php
namespace com\selfcoders\phputils;

class HTTPHeader
{
	/**
	 * @var array An array of HTTPCookie instances
	 */
	public $cookies = array();
	/**
	 * @var array An array of header fields
	 */
	public $headers = array();
	/**
	 * @var string The HTTP version (e.g. 1.0 or 1.1)
	 */
	public $version;
	/**
	 * @var int The status code (e.g. 200, 301 or 500)
	 */
	public $statusCode;
	/**
	 * @var string The status text (e.g. OK, Moved Permanently or Internal Server Error)
	 */
	public $statusText;
}