<?php

namespace Tests\Cp\Provider;

use Cp\DomainObject\Configuration;
use Cp\DomainObject\TypeInterface;
use Cp\Manager\ConfigurationManager;
use Cp\Provider\ConfigurationProvider;

/**
 * Class TypeProviderTest
 */
class ConfigurationProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $configurationMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $configurationManagerMock;

    /**
     * @var ConfigurationProvider
     */
    protected $configurationProvider;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->configurationManagerMock = $this
            ->getMockBuilder(ConfigurationManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configurationMock = $this
            ->getMockBuilder(Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test get collection of configuration by type name
     */
    public function testGetConfigurationByType()
    {
        $this->configurationManagerMock
            ->expects($this->any())
            ->method('findConfigurationsByType')
            ->with(TypeInterface::TYPE_10K)
            ->willReturn([
                $this->configurationMock,
                $this->configurationMock,
            ]);

        $expected = [
            $this->configurationMock,
            $this->configurationMock,
        ];

        $configurationProvider = new ConfigurationProvider($this->configurationManagerMock);

        $this->assertEquals(
            $expected,
            $configurationProvider->getConfigurationByType(TypeInterface::TYPE_10K)
        );
    }

    /**
     * Test if this method return a Configuration object
     */
    public function testGetConfiguration()
    {
        $this->configurationManagerMock
            ->expects($this->any())
            ->method('findConfiguration')
            ->willReturn($this->configurationMock);

        $configurationProvider = new ConfigurationProvider($this->configurationManagerMock);

        $this->assertInstanceOf(
            Configuration::class,
            $configurationProvider->getConfiguration(TypeInterface::TYPE_10K, 8, 3)
        );
    }

    /**
     * Test if this method return a Configuration object
     *
     * @expectedException \Cp\Exception\ConfigurationNotFoundException
     */
    public function testGetConfigurationNotFound()
    {
        $this->configurationManagerMock
            ->expects($this->any())
            ->method('findConfiguration')
            ->willReturn(null);

        $configurationProvider = new ConfigurationProvider($this->configurationManagerMock);

        $this->assertInstanceOf(
            Configuration::class,
            $configurationProvider->getConfiguration(TypeInterface::TYPE_10K, 999, 3)
        );
    }
}
