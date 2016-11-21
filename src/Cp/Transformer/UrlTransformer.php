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
}
