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
		$scheme = $url["scheme"];
		if (!$scheme)
		{
			$scheme = "http";
		}

		$fullUrl = "";
		$fullUrl .= $scheme;
		$fullUrl .= "://";

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

		$fullUrl .= $url["host"];

		$defaultPort = null;
		switch ($scheme)
		{
			case "http":
				$defaultPort = 80;
				break;
			case "https":
				$defaultPort = 443;
				break;
		}

		if ($defaultPort and isset($url["port"]) and $url["port"] != $defaultPort)
		{
			$fullUrl .= ":";
			$fullUrl .= $url["port"];
		}

		$fullUrl .= $url["path"];

		if ($url["query"])
		{
			$fullUrl .= "?";
			$fullUrl .= $url["query"];
		}

		if ($url["fragment"])
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