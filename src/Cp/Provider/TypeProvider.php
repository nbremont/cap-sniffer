<?php

namespace Cp\Provider;

use Cp\Manager\TypeManager;

/**
 * Class TypeProvider
 */
class TypeProvider
{
    /**
     * @var TypeManager
     */
    private $typeManager;

    /**
     * TypeProvider constructor.
     *
     * @param TypeManager $typeManager
     */
    public function __construct(TypeManager $typeManager)
    {
        $this->typeManager = $typeManager;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->typeManager->findAll();
    }

    /**
     * @return array
     */
    public function getAllName()
    {
        $names = [];
        foreach ($this->getAll() as $type) {
            $names[] = $type['name'];
        }

        return $names;
    }

    /**
     * @param $name
     *
     * @return string|null
     */
    public function getTypeByName($name)
    {
        return isset($this->getAll()[$name]) ? $this->getAll()[$name]['type'] : null;
    }
}
