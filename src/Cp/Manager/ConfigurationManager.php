<?php

namespace Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\Parser\ConfigurationParser;
use Cp\Provider\TypeProvider;
use Cp\Transformer\UrlTransformer;
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
     * @var UrlTransformer
     */
    protected $urlTransformer;

    /**
     * ConfigurationManager constructor.
     *
     * @param TypeProvider        $typeProvider
     * @param ConfigurationParser $configurationParser
     * @param MemcachedCache      $memcachedCache
     * @param UrlTransformer      $urlTransformer
     */
    public function __construct(
        TypeProvider $typeProvider,
        ConfigurationParser $configurationParser,
        MemcachedCache $memcachedCache,
        UrlTransformer $urlTransformer
    ) {
        $this->typeProvider = $typeProvider;
        $this->configurationParser = $configurationParser;
        $this->memcache = $memcachedCache;
        $this->urlTransformer = $urlTransformer;
    }

    /**
     * @param string $type
     * @param string $week
     * @param string $seance
     *
     * @return Configuration|null
     */
    public function findConfiguration($type, $week, $seance)
    {
        $configurationSearch = $this->createConfiguration($type, $week, $seance);
        foreach ($this->findConfigurationsByType($type) as $configuration) {
            if ($configurationSearch == $configuration) {
                return $configurationSearch;
            }
        }

        return null;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public function findConfigurationsByType($type)
    {
        $configurationForType = $this->memcache->fetch(self::CACHE_KEY.$type);

        if (false === $configurationForType) {
            $typeName = $this->typeProvider->getTypeByKey($type);
            $configurationForType = json_decode(
                $this->configurationParser->parseToJson(
                    $this->urlTransformer->transformType($typeName)
                ),
                true
            );

            $this
                ->memcache
                ->save(self::CACHE_KEY.$type, $configurationForType, 3600);
        }

        $configurationList = [];
        foreach ($configurationForType as $conf) {
            $configurationList[] = $this
                ->createConfiguration(
                    $type,
                    $conf['week'],
                    $conf['seance']
                );
        }

        return $configurationList;
    }

    /**
     * @param string $type
     * @param int    $week
     * @param int    $seance
     *
     * @return Configuration
     */
    public function createConfiguration($type, $week, $seance)
    {
        $configuration = new Configuration();
        $configuration->setType($type);
        $configuration->setNumberOfWeek($week);
        $configuration->setNumberOfSeance($seance);

        return $configuration;
    }
}
