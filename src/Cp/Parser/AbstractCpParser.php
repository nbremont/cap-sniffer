<?php

namespace Cp\Parser;

use PHPHtmlParser\Dom;

/**
 * Class AbstractCpParser
 */
class AbstractCpParser
{
    /**
     * @var Dom
     */
    protected $parser;

    /**
     * CpParser constructor.
     *
     * @param Dom $parser
     */
    public function __construct(Dom $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $url
     *
     * @throws \Exception
     */
    public function loadContent($url)
    {
        $htmlContent = file_get_contents($url);
        if (false === $htmlContent) {
            throw new \Exception(sprintf('Content can not be get from %s', $url));
        }

        $this->parser->load($htmlContent);
    }
}