<?php

namespace Tests\Cp\Manager;

use Cp\DomainObject\Plan;
use Cp\DomainObject\TypeInterface;
use Cp\Exception\ConfigurationException;
use Cp\Manager\PlanManager;
use Cp\Parser\PlanParser;
use Cp\Transformer\UrlTransformer;
use Doctrine\Common\Cache\MemcachedCache;
use JMS\Serializer\Serializer;

/**
 * Class PlanManagerTest
 */
class PlanManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $planParserMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $urlTransformerMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $memcachedCacheMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $serializerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $planMock = $this->getMockBuilder(Plan::class)->disableOriginalConstructor()->getMock();

        $this->planParserMock = $this
            ->getMockBuilder(PlanParser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlTransformerMock = $this
            ->getMockBuilder(UrlTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->memcachedCacheMock = $this
            ->getMockBuilder(MemcachedCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->memcachedCacheMock
            ->expects($this->any())
            ->method('fetch')
            ->willReturn(false)
        ;
        $this->serializerMock = $this
            ->getMockBuilder(Serializer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->serializerMock
            ->expects($this->any())
            ->method('deserialize')
            ->willReturn($planMock)
        ;
    }

    /**
     * Test find all elements of plan
     */
    public function testFindByTypeReturnPlanObject()
    {
        $planManager = new PlanManager(
            $this->planParserMock,
            $this->urlTransformerMock,
            $this->serializerMock,
            $this->memcachedCacheMock
        );

        $plan = $planManager->findByType(8, 3, TypeInterface::TYPE_10K);

        $this->assertInstanceOf(Plan::class, $plan);
    }

    /**
     * Test if Configuration exception is throw
     *
     * @expectedException \Cp\Exception\ConfigurationException
     */
    public function testThrowConfigurationException()
    {
        $this
            ->planParserMock
            ->expects($this->once())
            ->method('parseToJson')
            ->willThrowException(new ConfigurationException())
        ;

        $planManager = new PlanManager(
            $this->planParserMock,
            $this->urlTransformerMock,
            $this->serializerMock,
            $this->memcachedCacheMock
        );

        $planManager->findByType(8, 3, TypeInterface::TYPE_10K);
    }
}
