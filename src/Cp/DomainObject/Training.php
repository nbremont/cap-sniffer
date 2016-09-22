<?php

namespace Cp\DomainObject;

use JMS\Serializer\Annotation as JMS;

class Training
{
    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $content;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $type;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

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
}
