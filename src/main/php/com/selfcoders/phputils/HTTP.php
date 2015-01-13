<?php
namespace com\selfcoders\phputils;

class HTTP
{
	/**
	 * Parse the header content and return a new instance of the HTTPHeader class.
	 *
	 * @param string $content The raw header content
	 * @param bool $lowerCase Whether cookies and headers should be referenced using a lower case key
	 *
	 * @return HTTPHeader An instance of the HTTPHeader class containing the parsed data
	 */
	public static function parseHeader($content, $lowerCase = false)
	{
		$data = new HTTPHeader();

		$content = explode("\r\n", $content);

		foreach ($content as $line)
		{
			$headerLine = explode(":", trim($line), 2);

			if (count($headerLine) < 2)
			{
				continue;
			}

			list($headerKey, $headerValue) = $headerLine;

			$headerKey = trim($headerKey);

			if (strtolower($headerKey) == "set-cookie")
			{
				$cookie = new HTTPCookie();
				$cookie->parse($headerValue);

				if ($lowerCase)
				{
					$key = strtolower($cookie->name);
				}
				else
				{
					$key = $cookie->name;
				}

				$data->cookies[$key] = $cookie;
			}
			else
			{
				if ($lowerCase)
				{
					$headerKey = strtolower($headerKey);
				}

				$data->headers[$headerKey] = trim($headerValue);
			}
		}

		return $data;
	}
}