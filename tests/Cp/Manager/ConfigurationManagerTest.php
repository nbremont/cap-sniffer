<?php

namespace Tests\Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\DomainObject\TypeInterface;
use Cp\Manager\ConfigurationManager;
use Cp\Parser\ConfigurationParser;
use Cp\Provider\TypeProvider;
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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->typeProviderMock = $this->getMockBuilder(TypeProvider::class)->disableOriginalConstructor()->getMock();

        $this->configurationParserMock = $this
            ->getMockBuilder(ConfigurationParser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->memcacheMock = $this
            ->getMockBuilder(MemcachedCache::class)
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
            $this->memcacheMock
        );

        $this->assertInstanceOf(
            Configuration::class,
            $configurationManager->createConfiguration(TypeInterface::TYPE_10K, 8, 3)
        );
    }
}
