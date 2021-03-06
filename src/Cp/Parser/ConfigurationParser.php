<?php

namespace Cp\Parser;

use Cp\Transformer\UrlTransformer;
use JMS\Serializer\Exception\LogicException;

/**
 * Class ConfigurationParser
 */
class ConfigurationParser extends AbstractCpParser
{
    /**
     * @var UrlTransformer
     */
    protected $urlTransformer;

    /**
     * @param string $url
     *
     * @return string
     * @throws \Exception
     */
    public function parseToJson($url)
    {
        $this->loadContent($url);
        $configurations = $this->parser->find('ul#blocsplans li');
        if (0 >= $configurations->count()) {
            throw new \Exception(sprintf('Configuration not found for this url: %s', $url));
        }

        $configurationList = [];
        foreach ($configurations as $conf) {
            foreach ($conf->find('p a') as $link) {
                $configurationFor = $this->getUrlTransformer()->reverseConfiguration($link->href);
                if (null !== $configurationFor) {
                    $configurationList[] = $configurationFor;
                }
            }
        }

        return json_encode($configurationList, true);
    }

    /**
     * @return UrlTransformer
     *
     * @throws LogicException
     */
    public function getUrlTransformer()
    {
        if (null === $this->urlTransformer) {
            throw new LogicException('urlTransformer is not set, call setUrlTransformer for it');
        }

        return $this->urlTransformer;
    }

    /**
     * @param UrlTransformer $urlTransformer
     */
    public function setUrlTransformer(UrlTransformer $urlTransformer)
    {
        $this->urlTransformer = $urlTransformer;
    }
}
