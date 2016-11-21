<?php

namespace Cp\Http;

/**
 * Class HeaderParser
 *
 * @package Cp\Http
 */
class HeaderParser
{
    /**
     * @param array $httpResponseHeader
     *
     * @return array
     */
    public function parseHeaders(array $httpResponseHeader)
    {
        $head = array();
        foreach ($httpResponseHeader as $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', $v, $out) && !isset($head['response_code'])) {
                    $head['response_code'] = intval($out[1]);
                }
            }
        }

        return $head;
    }

    /**
     * @param string $headerProperty
     * @param array  $httpResponseHeader
     *
     * @return string
     */
    public function get($headerProperty, array $httpResponseHeader)
    {
        return isset($this->parseHeaders($httpResponseHeader)[$headerProperty])
            ? $this->parseHeaders($httpResponseHeader)[$headerProperty]
            : null;
    }
}
