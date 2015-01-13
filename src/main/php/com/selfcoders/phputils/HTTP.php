<?php
namespace com\selfcoders\phputils;

class HTTP
{
	/**
	 * Parse the header content and return a new instance of the HTTPHeader class.
	 *
	 * @param string $content The raw header content
	 *
	 * @return HTTPHeader An instance of the HTTPHeader class containing the parsed data
	 */
	public static function parseHeader($content)
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

				$data->cookies[$cookie->name] = $cookie;
			}
			else
			{
				$data->headers[$headerKey] = trim($headerValue);
			}
		}

		return $data;
	}
}