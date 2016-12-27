<?php

namespace Cp\Transformer;

/**
 * Class UrlTransformer
 */
class UrlTransformer
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * UrlTransformer constructor.
     *
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $week
     * @param string $seance
     * @param string $type
     *
     * @return string
     */
    public function transformPlan($week, $seance, $type)
    {
        return sprintf(
            '%s/plan-entrainement/%s/%s-seances-%s-semaines.html',
            $this->baseUrl,
            $type,
            $seance,
            $week
        );
    }

    /**
     * @param string $typeName
     *
     * @return string
     */
    public function transformType($typeName)
    {
        return sprintf('%s/plan-entrainement/%s.html', $this->baseUrl, $typeName);
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public function reverseConfiguration($url)
    {
        $thirdPart = substr($url, strrpos($url, '/') + 1);
        preg_match_all('/^([\d]{1,2})-[\w]+-([\d]{1,2})/', $thirdPart, $matches);

        $seance = isset($matches[1][0]) ? $matches[1][0] : null;
        $week = isset($matches[2][0]) ? $matches[2][0] : null;

        if (null === $seance || null === $week) {
            return null;
        }

        return [
            'seance' => $seance,
            'week' => $week,
        ];
    }
}
