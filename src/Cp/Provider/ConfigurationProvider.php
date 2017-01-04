<?php

namespace Cp\Provider;

use Cp\DomainObject\Configuration;
use Cp\Exception\ConfigurationNotFoundException;
use Cp\Manager\ConfigurationManager;

/**
 * Class Type
 */
class ConfigurationProvider
{
    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * ConfigurationProvider constructor.
     *
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param string $typeName
     *
     * @return array
     */
    public function getConfigurationByType($typeName)
    {
        return $this->configurationManager->findConfigurationsByType($typeName);
    }

    /**
     * @param string $typeName
     * @param string $week
     * @param string $seance
     *
     * @return Configuration
     * @throws ConfigurationNotFoundException
     */
    public function getConfiguration($typeName, $week, $seance)
    {
        $configuration = $this->configurationManager->findConfiguration($typeName, $week, $seance);
        if (null === $configuration) {
            throw new ConfigurationNotFoundException(
                sprintf(
                    'Configuration with week: %s, seance: %s and type:%s is not available',
                    $week,
                    $seance,
                    $typeName
                )
            );
        }

        return $configuration;
    }
}
