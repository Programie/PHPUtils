<?php
namespace com\selfcoders\phputils;

class URL
{
	/**
	 * Opposite of parse_url: Builds an URL string from the given array returned by parse_url.
	 *
	 * @param array $url The array returned bu parse_url
	 *
	 * @return string The full URL
	 */
	public static function buildUrl($url)
	{
		$fullUrl = "";

		if (isset($url["scheme"]))
		{
			$fullUrl .= $url["scheme"];
			$fullUrl .= "://";
		}

		if (isset($url["user"]))
		{
			$fullUrl .= $url["user"];
			if (isset($url["pass"]))
			{
				$fullUrl .= ":";
				$fullUrl .= $url["pass"];
			}
			$fullUrl .= "@";
		}

		if (isset($url["host"]))
		{
			$fullUrl .= $url["host"];
		}

		if (isset($url["port"]))
		{
			$fullUrl .= ":";
			$fullUrl .= $url["port"];
		}

		if (isset($url["path"]))
		{
			$fullUrl .= $url["path"];
		}

		if (isset($url["query"]))
		{
			$fullUrl .= "?";
			$fullUrl .= $url["query"];
		}

		if (isset($url["fragment"]))
		{
			$fullUrl .= "#";
			$fullUrl .= $url["fragment"];
		}

		return $fullUrl;
	}

	/**
	 * Returns the root URL (e.g. http://example.com or https://sub.example.com:8443)
	 *
	 * @return string The URL
	 */
	public static function getRootUrl()
	{
		return ($_SERVER["HTTPS"] ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
	}
}