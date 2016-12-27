<?php

namespace Tests\Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\DomainObject\TypeInterface;
use Cp\Manager\ConfigurationManager;
use Cp\Parser\ConfigurationParser;
use Cp\Provider\TypeProvider;
use Cp\Transformer\UrlTransformer;
use Doctrine\Common\Cache\MemcachedCache;

/**
 * Class ConfigurationManagerTest
 */
class ConfigurationManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $typeProviderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $configurationParserMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $memcacheMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $urlTransformerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->typeProviderMock = $this
            ->getMockBuilder(TypeProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->typeProviderMock
            ->expects($this->any())
            ->method('gettypebyname')
            ->with(TypeInterface::TYPE_10K)
            ->willReturn(10);

        $this->configurationParserMock = $this
            ->getMockBuilder(ConfigurationParser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->memcacheMock = $this
            ->getMockBuilder(MemcachedCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlTransformerMock = $this
            ->getMockBuilder(UrlTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test create Configuration object
     */
    public function testCreateConfiguration()
    {
        $configurationManager = new ConfigurationManager(
            $this->typeProviderMock,
            $this->configurationParserMock,
            $this->memcacheMock,
            $this->urlTransformerMock
        );

        $this->assertInstanceOf(
            Configuration::class,
            $configurationManager->createConfiguration(TypeInterface::TYPE_10K, 8, 3)
        );
    }

    /**
     * Test find collection of Configuration
     */
    public function testFindConfigurationsByType()
    {
        $this->memcacheMock
            ->expects($this->any())
            ->method('fetch')
            ->willReturn(false);

        $this->configurationParserMock
            ->expects($this->any())
            ->method('parseToJson')
            ->willReturn('[
                { "type": "'.TypeInterface::TYPE_10K.'", "week": "8", "seance": "3" }
            ]');

        $configurationManager = new ConfigurationManager(
            $this->typeProviderMock,
            $this->configurationParserMock,
            $this->memcacheMock,
            $this->urlTransformerMock
        );

        $configurationCollection = $configurationManager->findConfigurationsByType(TypeInterface::TYPE_10K);
        $configuration = $configurationCollection[0];

        $this->assertInstanceOf(Configuration::class, $configurationCollection[0]);
        $this->assertEquals(10, $configuration->getType());
        $this->assertEquals(8, $configuration->getNumberOfWeek());
        $this->assertEquals(3, $configuration->getNumberOfSeance());
    }
}
