<?php

namespace Tests\Cp;

use Cocur\Slugify\Slugify;
use Cp\Calendar\Builder\CalendarBuilder;
use Cp\CapSniffer;
use Cp\DomainObject\Configuration;
use Cp\DomainObject\Plan;
use Cp\DomainObject\TypeInterface;
use Cp\Manager\ConfigurationManager;
use Cp\Provider\PlanProvider;
use Cp\Provider\TypeProvider;

/**
 * Class CapSnifferTest
 */
class CapSnifferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $typeProviderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $planProviderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $calendarBuilderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $slugMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $configurationManagerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->removeTestFiles();

        $planMock = $this->getMockBuilder(Plan::class)->disableOriginalConstructor()->getMock();
        $configurationMock = $this->getMockBuilder(Configuration::class)->disableOriginalConstructor()->getMock();

        $this->typeProviderMock = $this->getMockBuilder(TypeProvider::class)->disableOriginalConstructor()->getMock();
        $this->planProviderMock = $this->getMockBuilder(PlanProvider::class)->disableOriginalConstructor()->getMock();

        $this->calendarBuilderMock = $this
            ->getMockBuilder(CalendarBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->slugMock = $this
            ->getMockBuilder(Slugify::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->configurationManagerMock = $this
            ->getMockBuilder(ConfigurationManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->slugMock
            ->expects($this->any())
            ->method('slugify')
            ->willReturn('plans-entrainement-10-km-en-50-55-minutes')
        ;

        $this->configurationManagerMock
            ->expects($this->any())
            ->method('createConfiguration')
            ->willReturn($configurationMock);

        $this->planProviderMock
            ->expects($this->any())
            ->method('getPlanByConfiguration')
            ->willReturn($planMock);

        $this->calendarBuilderMock
            ->expects($this->any())
            ->method('exportCalendar')
            ->willReturn('some stream');
    }

    /**
     * Test generation of Calendar
     */
    public function testGenerateCalendar()
    {
        $capSniffer = new CapSniffer(
            $this->typeProviderMock,
            $this->planProviderMock,
            $this->calendarBuilderMock,
            $this->slugMock,
            $this->configurationManagerMock
        );

        $actual = $capSniffer->generateCalendar(TypeInterface::TYPE_10K, 8, 3);

        $this->assertEquals('some stream', $actual);
    }

    /**
     * Test writing file
     */
    public function testWriteCalendar()
    {
        $capSniffer = new CapSniffer(
            $this->typeProviderMock,
            $this->planProviderMock,
            $this->calendarBuilderMock,
            $this->slugMock,
            $this->configurationManagerMock
        );

        $capSniffer->writeCalendar(TypeInterface::TYPE_10K, 8, 3);

        $this->assertTrue(is_file('./plans-entrainement-10-km-en-50-55-minutes.ics'));
        $this->assertEquals('some stream', file_get_contents('./plans-entrainement-10-km-en-50-55-minutes.ics'));
    }

    /**
     * Test message with calendar was generated with success
     */
    public function testGetFileName()
    {
        $capSniffer = new CapSniffer(
            $this->typeProviderMock,
            $this->planProviderMock,
            $this->calendarBuilderMock,
            $this->slugMock,
            $this->configurationManagerMock
        );

        $this->assertEquals(
            'plans-entrainement-10-km-en-50-55-minutes.ics',
            $capSniffer->getFileName(TypeInterface::TYPE_10K, 8, 3)
        );
    }

    /**
     * Remove files generate by tests
     */
    private function removeTestFiles()
    {
        if (is_file('./plans-entrainement-10-km-en-50-55-minutes.ics')) {
            unlink('./plans-entrainement-10-km-en-50-55-minutes.ics');
        }
    }
}
