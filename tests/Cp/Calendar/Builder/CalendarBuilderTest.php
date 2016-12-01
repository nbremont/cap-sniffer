<?php

namespace Tests\Cp\Calendar\Builder;

use Cp\Calendar\Builder\CalendarBuilder;
use Cp\Calendar\Builder\CalendarEventBuilder;
use Cp\DomainObject\Configuration;
use Cp\DomainObject\Plan;
use Cp\DomainObject\Week;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\CalendarEvent;

/**
 * Class CalendarBuilderTest
 */
class CalendarBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $calendarExportMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $calendarEventBuilderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder
     */
    protected $planMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->calendarExportMock = $this->getMockBuilder(CalendarExport::class)->disableOriginalConstructor()->getMock();
        $weekMock = $this->getMockBuilder(Week::class)->disableOriginalConstructor()->getMock();

        $configurationMock = $this->getMockBuilder(Configuration::class)->disableOriginalConstructor()->getMock();
        $configurationMock
            ->expects($this->any())
            ->method('getNumberOfSeance')
            ->willReturn(3)
        ;

        $this->planMock = $this->getMockBuilder(Plan::class)->disableOriginalConstructor()->getMock();
        $this->planMock
            ->expects($this->any())
            ->method('getWeeks')
            ->willReturn([
                $weekMock,
            ])
        ;

        $this->planMock
            ->expects($this->any())
            ->method('getConfiguration')
            ->willReturn($configurationMock)
        ;

        $this->calendarEventBuilderMock = $this
            ->getMockBuilder(CalendarEventBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $calendarEventMock = $this->getMockBuilder(CalendarEvent::class)->disableOriginalConstructor()->getMock();
        $this->calendarEventBuilderMock
            ->expects($this->any())
            ->method('build')
            ->willReturn([
                $calendarEventMock,
                $calendarEventMock,
                $calendarEventMock,
            ])
        ;
    }

    /**
     * Test build Calendar
     */
    public function testBuild()
    {
        $this->calendarExportMock
            ->expects($this->once())
            ->method('addCalendar')
        ;

        $calendarBuilder = new CalendarBuilder($this->calendarExportMock, $this->calendarEventBuilderMock);
        $calendarBuilder->build($this->planMock);
    }

    /**
     * Test export calendar
     */
    public function testExportCalendar()
    {
        $this->calendarExportMock
            ->expects($this->once())
            ->method('getStream')
        ;

        $calendarBuilder = new CalendarBuilder($this->calendarExportMock, $this->calendarEventBuilderMock);
        $calendarBuilder->exportCalendar($this->planMock);
    }

    /**
     * Test get recovery day for specific seance number
     */
    public function testGetRecoveryDay()
    {
        $calendarBuilder = new CalendarBuilder($this->calendarExportMock, $this->calendarEventBuilderMock);

        $this->assertEquals([3, 3, 3], $calendarBuilder->getRecoveryDay(3));
        $this->assertEquals([2, 2, 2, 2], $calendarBuilder->getRecoveryDay(4));
        $this->assertEquals([1, 2, 1, 2, 1], $calendarBuilder->getRecoveryDay(5));
        $this->assertEquals([1, 1, 1, 1, 1, 1], $calendarBuilder->getRecoveryDay(6));
        $this->assertEquals([1, 1, 1, 1, 1, 1, 1], $calendarBuilder->getRecoveryDay(7));

        $this->assertNull($calendarBuilder->getRecoveryDay(0));
    }
}
