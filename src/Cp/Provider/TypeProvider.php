<?php

namespace Cp\Provider;

use Cp\DomainObject\TypeInterface;

/**
 * Class Type
 */
class TypeProvider
{
    /**
     * @return array
     */
    public function getTypes()
    {
        return [
            '10' => TypeInterface::TYPE_10K,
            '21' => TypeInterface::TYPE_SEMI,
            '42' => TypeInterface::TYPE_MARATHON,
        ];
    }

    /**
     * @param string $type
     *
     * @return string|null
     */
    public function getTypeByName($type)
    {
        $key = array_search($type, $this->getTypes());

        return false !== $key ? $key : null;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getTypeByKey($key)
    {
        return isset($this->getTypes()[$key]) ? $this->getTypes()[$key] : null;
    }
}
