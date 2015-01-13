<?php
namespace com\selfcoders\phputils;

class HTTPCookie
{
	/**
	 * @var string The name of the cookie
	 */
	public $name;
	/**
	 * @var string The value of the cookie
	 */
	public $value;
	/**
	 * @var string The expire date of the cookie
	 */
	public $expires;
	/**
	 * @var string The path for which the cookie should be valid
	 */
	public $path;
	/**
	 * @var string The domain for which the domain should be valid
	 */
	public $domain;
	/**
	 * @var bool Whether the cookie is flagged as "secure" (only sent via HTTPS)
	 */
	public $secure = false;

	public function parse($string)
	{
		foreach (explode(";", $string) as $index => $field)
		{
			$keyValue = explode("=", $field, 2);

			$key = $keyValue[0];

			if (count($keyValue) == 2)
			{
				$value = $keyValue[1];
			}
			else
			{
				$value = null;
			}

			$key = trim($key);
			$value = trim($value);

			// The first field is always the "name=value" pair
			if ($index == 0)
			{
				$this->name = $key;
				$this->value = $value;
				continue;
			}

			switch (strtolower($key))
			{
				case "expires":
					$this->expires = $value;
					break;
				case "path":
					$this->path = $value;
					break;
				case "domain":
					$this->domain = $value;
					break;
				case "secure":
					$this->secure = true;
					continue;
			}
		}
	}
}