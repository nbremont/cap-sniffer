<?php

namespace Tests\Cp\Manager;

use Cp\DomainObject\Configuration;
use Cp\DomainObject\TypeInterface;
use Cp\Manager\ConfigurationManager;
use Cp\Provider\TypeProvider;

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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->typeProviderMock = $this->getMockBuilder(TypeProvider::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Test create Configuration object
     */
    public function testCreateConfiguration()
    {
        $configurationManager = new ConfigurationManager($this->typeProviderMock);

        $this->assertInstanceOf(
            Configuration::class,
            $configurationManager->createConfiguration(TypeInterface::TYPE_10K, 8, 3)
        );
    }
}
