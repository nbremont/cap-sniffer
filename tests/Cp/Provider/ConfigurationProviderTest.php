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

        $this->configurationManagerMock
            ->expects($this->once())
            ->method('findConfigurationsByType')
            ->with(TypeInterface::TYPE_10K)
            ->willReturn([
                $this->configurationMock,
                $this->configurationMock,
            ]);

        $this->configurationProvider = new ConfigurationProvider($this->configurationManagerMock);
    }

    /**
     * Test get collection of configuration by type name
     */
    public function testGetConfigurationByType()
    {
        $expected = [
            $this->configurationMock,
            $this->configurationMock,
        ];

        $this->assertEquals(
            $expected,
            $this->configurationProvider->getConfigurationByType(TypeInterface::TYPE_10K)
        );
    }
}
