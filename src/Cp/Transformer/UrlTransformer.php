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
     * @var array
     */
    private $types;

    /**
     * UrlTransformer constructor.
     *
     * @param string $baseUrl
     * @param array  $types
     */
    public function __construct($baseUrl, array $types)
    {
        $this->baseUrl = $baseUrl;
        $this->types = $types;
    }

    /**
     * @param string $seance
     * @param string $week
     * @param string $type
     *
     * @return string
     */
    public function transform($seance, $week, $type)
    {
        return sprintf('%s/plan-entrainement/plan-entrainement-%s/%s-seances-%s-semaines.html',
            $this->baseUrl,
            $this->getType($type),
            $seance,
            $week
        );
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types)
    {
        $this->types = $types;
    }

    /**
     * @param string $type
     *
     * @return string|null
     */
    public function getType($type)
    {
        if (in_array($type, $this->types)) {
            return $type;
        }

        return null;
    }
}
