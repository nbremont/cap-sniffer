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
     * @return string
     * @throws \Exception
     */
    public function getTypeByName($type)
    {
        $key = array_search($type, $this->getTypes());

        if (false !== $key) {
            return $key;
        }

        throw new \Exception(sprintf(
            'Type: "%s" not found, allowed %s',
            $type,
            implode(', ', $this->getTypes())
        ));
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws \Exception
     */
    public function getTypeByKey($key)
    {
        if (isset($this->getTypes()[$key])) {
            return $this->getTypes()[$key];
        }

        throw new \Exception(sprintf(
            'Key: "%s" not found, allowed %s',
            $key,
            implode(', ', array_keys($this->getTypes()))
        ));
    }
}
