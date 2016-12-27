<?php

namespace Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\Parser\ConfigurationParser;
use Cp\Provider\TypeProvider;
use Doctrine\Common\Cache\MemcachedCache;

/**
 * Class ConfigurationManager
 */
class ConfigurationManager
{
    const CACHE_KEY = 'configuration.list';

    /**
     * @var TypeProvider
     */
    private $typeProvider;

    /**
     * @var ConfigurationParser
     */
    protected $configurationParser;

    /**
     * @var MemcachedCache
     */
    protected $memcache;

    /**
     * ConfigurationManager constructor.
     *
     * @param TypeProvider        $typeProvider
     * @param ConfigurationParser $configurationParser
     * @param MemcachedCache      $memcachedCache
     */
    public function __construct(
        TypeProvider $typeProvider,
        ConfigurationParser $configurationParser,
        MemcachedCache $memcachedCache
    ) {
        $this->typeProvider = $typeProvider;
        $this->configurationParser = $configurationParser;
        $this->memcache = $memcachedCache;
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
        $type = $this->typeProvider->getTypeByName($typeName);

        $configuration = new Configuration();
        $configuration->setType($type);
        $configuration->setNumberOfWeek($week);
        $configuration->setNumberOfSeance($seance);

        return $configuration;
    }

    /**
     * @param string $typeName
     *
     * @return array
     */
    public function findConfigurationsByType($typeName)
    {
        $configurationForType = $this->memcache->fetch(self::CACHE_KEY.$typeName);

        if (false === $configurationForType) {
            $configurationForType = json_decode(
                $this
                    ->configurationParser
                    ->parseToJson('/Users/perso/Workspace/cap-sniffer-api/web/mock/plan-10-home.html')
                , true);
            $this->memcache->save(self::CACHE_KEY.$typeName, $configurationForType, 3600);
        }

        $configurationList = [];
        foreach ($configurationForType as $conf) {
            $configuration = new Configuration();
            $configuration->setType($typeName);
            $configuration->setNumberOfSeance($conf['seance']);
            $configuration->setNumberOfWeek($conf['week']);

            $configurationList[] = $configuration;
        }

        return $configurationList;
    }
}
