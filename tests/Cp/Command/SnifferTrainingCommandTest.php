<?php

namespace Tests\Cp\Command;

use Cp\CapSniffer;
use Cp\Command\SnifferTrainingCommand;
use Cp\Provider\TypeProvider;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SnifferTrainingCommandTest
 */
class SnifferTrainingCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testCapSnifferCommandSuccess()
    {
        $capSnifferMock = $this->getMockBuilder(CapSniffer::class)->disableOriginalConstructor()->getMock();
        $typeProviderMock = $this->getMockBuilder(TypeProvider::class)->disableOriginalConstructor()->getMock();
        $typeProviderMock
            ->expects($this->any())
            ->method('getTypes')
            ->willReturn([
                'plan-entrainement-10km',
                'plan-entrainement-semi-marathon',
                'plan-entrainement-marathon',
            ])
        ;

        $snifferCommand = new SnifferTrainingCommand($typeProviderMock, $capSnifferMock);

        $application = new Application();
        $application->add($snifferCommand);

        $command = $application->find('cp:sniffer');

        // We override the standard helper with our mock
        $helperMock = $this->getMockBuilder(QuestionHelper::class)->disableOriginalConstructor()->getMock();
        $helperMock
            ->expects($this->any())
            ->method('ask')
            ->willReturn(0)
        ;

        $command->getHelperSet()->set($helperMock, 'question');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName())
        );

        $this->assertRegExp('/Calendar generate sucessfuly\n/', $commandTester->getDisplay());
    }
}
