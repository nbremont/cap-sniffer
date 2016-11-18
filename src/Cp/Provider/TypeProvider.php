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
            TypeInterface::TYPE_10k,
            TypeInterface::TYPE_SEMI,
            TypeInterface::TYPE_MARATHON,
        ];
    }

    /**
     * @param string $type
     *
     * @return string|null
     */
    public function getType($type)
    {
        $key = array_search($type, $this->getTypes());

        return false !== $key ? $this->getTypes()[$key] : null;
    }
}
