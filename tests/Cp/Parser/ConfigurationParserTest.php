<?php

namespace Tests\Cp\Parser;

use Cp\Parser\ConfigurationParser;
use Cp\Transformer\UrlTransformer;
use PHPHtmlParser\Dom;

/**
 * Class ConfigurationParserTest
 */
class ConfigurationParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $dom;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $urlTransformer;

    /**
     * @var ConfigurationParser
     */
    protected $configurationParser;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->urlTransformer = $this
            ->getMockBuilder(UrlTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlTransformer
            ->expects($this->any())
            ->method('reverseConfiguration')
            ->willReturn([
                'seance' => 3,
                'week' => 8,
            ]);

        $this->configurationParser = new ConfigurationParser(new Dom());
        $this->configurationParser->setUrlTransformer($this->urlTransformer);
    }

    /**
     *
     */
    public function testParseToJson()
    {
        $contentJson = $this->configurationParser->parseToJson(__DIR__.'/../../fixtures/html/plan-10-home.html');
        $expected = [
            [
                'seance' => 3,
                'week' => 8,
            ],
            [
                'seance' => 3,
                'week' => 8,
            ],
            [
                'seance' => 3,
                'week' => 8,
            ],
        ];

        $this->assertEquals(json_encode($expected), $contentJson);
    }

    /**
     * @expectedException Exception
     */
    public function testParseToJsonException()
    {
        $contentJson = $this->configurationParser->parseToJson(__DIR__.'/../../fixtures/html/wrong-page.htm');
        $expected = [
            [
                'seance' => 3,
                'week' => 8,
            ],
            [
                'seance' => 3,
                'week' => 8,
            ],
            [
                'seance' => 3,
                'week' => 8,
            ],
        ];

        $this->assertEquals(json_encode($expected), $contentJson);
    }

    /**
     * @expectedException LogicException
     */
    public function testParseToJsonLogicException()
    {
        $this->configurationParser = new ConfigurationParser(new Dom());
        $this->configurationParser->parseToJson(__DIR__.'/../../fixtures/html/plan-10-home.html');
    }
}
