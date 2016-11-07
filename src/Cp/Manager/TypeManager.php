<?php

namespace Cp\Manager;

use Cp\Parser\TypeParser;
use Doctrine\Common\Cache\MemcachedCache;

/**
 * Class TypeManager
 */
class TypeManager
{
    const KEY_TYPE_OF_TRAINING = 'type_of_training';

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
        $result = $this->memcache->fetch(self::KEY_TYPE_OF_TRAINING);
        if (false == $result) {
            $result = $this->typeParser->parseToArray($this->urlSource);
            $this->memcache->save(self::KEY_TYPE_OF_TRAINING, $result, 3600);
        }

        return $result;
    }
}
