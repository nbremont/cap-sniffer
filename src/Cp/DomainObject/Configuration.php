<?php

namespace Cp\DomainObject;

/**
 * Class Category
 */
class Configuration
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $numberOfWeek;

    /**
     * @var int
     */
    private $numberOfSeance;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getNumberOfWeek()
    {
        return $this->numberOfWeek;
    }

    /**
     * @param int $numberOfWeek
     */
    public function setNumberOfWeek($numberOfWeek)
    {
        $this->numberOfWeek = $numberOfWeek;
    }

    /**
     * @return int
     */
    public function getNumberOfSeance()
    {
        return $this->numberOfSeance;
    }

    /**
     * @param int $numberOfSeance
     */
    public function setNumberOfSeance($numberOfSeance)
    {
        $this->numberOfSeance = $numberOfSeance;
    }

}