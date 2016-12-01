<?php

namespace Tests\Cp\Calendar\Builder;

use Cp\Calendar\Builder\CalendarEventBuilder;
use Cp\DomainObject\Training;
use Cp\DomainObject\Week;
use Jsvrcek\ICS\Model\CalendarEvent;

/**
 * Class CalendarEventBuilderTest
 */
class CalendarEventBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test build collection of CalendarEvent
     */
    public function testbuild()
    {
        $trainingMock = $this->getMockBuilder(Training::class)->disableOriginalConstructor()->getMock();
        $trainingMock
            ->expects($this->exactly(2))
            ->method('getContent')
            ->willReturn('Footing 45 mins')
        ;

        $weekMock = $this->getMockBuilder(Week::class)->disableOriginalConstructor()->getMock();
        $weekMock
            ->expects($this->any())
            ->method('getTrainings')
            ->willReturn([
                $trainingMock,
                $trainingMock,
            ])
        ;

        $calendarEventBuilder = new CalendarEventBuilder();
        $events = $calendarEventBuilder->build($weekMock);

        foreach ($events as $event) {
            $this->assertInstanceOf(CalendarEvent::class, $event);
        }
    }
}
