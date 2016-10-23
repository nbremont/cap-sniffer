<?php

namespace Cp\Manager;
use Cp\DomainObject\Configuration;
use Cp\Parser\TypeParser;

/**
 * Class ConfigurationManager
 */
class ConfigurationManager
{
    /**
     * @var TypeParser
     */
    private $typeParser;

    /**
     * ConfigurationManager constructor.
     *
     * @param TypeParser $typeParser
     * @param string     $urlSource
     */
    public function __construct(TypeParser $typeParser, $urlSource)
    {
        $this->typeParser = $typeParser;
        $this->urlSource = $urlSource;
    }
}