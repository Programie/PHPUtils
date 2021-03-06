<?php
namespace com\selfcoders\phputils;

class HTTP
{
    /**
     * Parse the header content and return a new instance of the HTTPHeader class.
     *
     * @param string|array $content The raw header content
     * @param bool $lowerCase Whether cookies and headers should be referenced using a lower case key
     *
     * @return HTTPHeader[] An array of HTTPHeader instances containing the parsed data (One instance per header part)
     */
    public static function parseHeader($content, $lowerCase = false)
    {
        $data = array();

        if (!is_array($content)) {
            $content = explode("\r\n\r\n", $content);
        }

        foreach ($content as $header) {
            $header = trim($header);

            if (!$header) {
                continue;
            }

            $header = explode("\r\n", $header);

            $headerInstance = new HTTPHeader();

            foreach ($header as $lineIndex => $line) {
                if ($lineIndex == 0) {
                    if (preg_match("/^HTTP\/([0-9\.]+) ([0-9]+) (.*)/", $line, $matches)) {
                        $headerInstance->version = $matches[1];
                        $headerInstance->statusCode = (int)$matches[2];
                        $headerInstance->statusText = $matches[3];
                    }

                    continue;
                }

                $headerLine = explode(":", trim($line), 2);

                if (count($headerLine) < 2) {
                    continue;
                }

                list($headerKey, $headerValue) = $headerLine;

                $headerKey = trim($headerKey);

                if (strtolower($headerKey) == "set-cookie") {
                    $cookie = new HTTPCookie();
                    $cookie->parse($headerValue);

                    if ($lowerCase) {
                        $key = strtolower($cookie->name);
                    } else {
                        $key = $cookie->name;
                    }

                    $headerInstance->cookies[$key] = $cookie;
                } else {
                    if ($lowerCase) {
                        $headerKey = strtolower($headerKey);
                    }

                    $headerInstance->headers[$headerKey] = trim($headerValue);
                }
            }

            $data[] = $headerInstance;
        }

        return $data;
    }
}