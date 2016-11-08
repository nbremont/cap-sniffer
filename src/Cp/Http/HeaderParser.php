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
     * @param array $http_response_header
     *
     * @return array
     */
    public function parseHeaders(array $http_response_header)
    {
        $head = array();
        foreach ($http_response_header as $k => $v) {
            $t = explode( ':', $v, 2 );
            if (isset( $t[1] )) {
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
     * @param array $headerProperty
     * @param array $http_response_header
     *
     * @return string
     */
    public function get($headerProperty, array $http_response_header)
    {
        return isset($this->parseHeaders($http_response_header)[$headerProperty])
            ? $this->parseHeaders($http_response_header)[$headerProperty]
            : null;
    }
}
