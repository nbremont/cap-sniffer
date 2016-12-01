<?php

namespace Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\Provider\TypeProvider;

/**
 * Class ConfigurationManager
 */
class ConfigurationManager
{
    /**
     * @var TypeProvider
     */
    private $typeProvider;

    /**
     * ConfigurationManager constructor.
     *
     * @param TypeProvider $typeProvider
     */
    public function __construct(TypeProvider $typeProvider)
    {
        $this->typeProvider = $typeProvider;
    }

    /**
     * @param string $typeName
     * @param int    $week
     * @param int    $seance
     *
     * @return Configuration
     */
    public function createConfiguration($typeName, $week, $seance)
    {
        $type = $this->typeProvider->getType($typeName);

        $configuration = new Configuration();
        $configuration->setType($type);
        $configuration->setNumberOfWeek($week);
        $configuration->setNumberOfSeance($seance);

        return $configuration;
    }
}
