<?php

namespace Cp\Manager;

use Cp\Parser\TypeParser;
use Doctrine\Common\Cache\MemcachedCache;

/**
 * Class TypeManager
 */
class TypeManager
{
    /**
     * @var TypeParser
     */
    private $typeParser;

    /**
     * @var string
     */
    private $urlSource;

    /**
     * @var MemcachedCache
     */
    private $memcache;

    /**
     * TypeManager constructor.
     *
     * @param TypeParser     $typeParser
     * @param string         $urlSource
     * @param MemcachedCache $memcachedCache
     */
    public function __construct(TypeParser $typeParser, $urlSource, MemcachedCache $memcachedCache)
    {
        $this->typeParser = $typeParser;
        $this->urlSource = $urlSource;
        $this->memcache = $memcachedCache;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        //$this->memcache->save('cache_id', 'my_data');
        return $this->typeParser->parseToArray($this->urlSource);
    }
}
