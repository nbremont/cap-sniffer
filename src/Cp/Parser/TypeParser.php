<?php

namespace Cp\Parser;

use PHPHtmlParser\Dom;

/**
 * Class TypeParser
 */
class TypeParser
{
    /**
     * @var Dom
     */
    private $parser;

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
     * @return string
     */
    public function parseToArray($url)
    {
        $htmlContent = file_get_contents($url);
        $this->parser->load($htmlContent);

        $types = [];

        $htmlTypes = $this->parser->find('#blocssommaire li');
        foreach ($htmlTypes as $type) {
            $url = $type->find('h3 a')->href;
            $typeStr = substr($url, strrpos($url, '/') + 1, -5);
            $types[$typeStr] = [
                'name' => $type->find('h3 a')->innerHtml,
                'url' => $url,
                'type' => $typeStr,
            ];
        }

        return $types;
    }
}
