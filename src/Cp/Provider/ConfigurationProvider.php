<?php

namespace Cp\Provider;

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
}
