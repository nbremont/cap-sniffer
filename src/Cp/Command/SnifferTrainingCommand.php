<?php

namespace Cp\Command;

use Cp\Calendar\CalendarBuilder;
use Cp\Calendar\CalendarEventBuilder;
use Cp\DomainObject\Plan;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

class SnifferTrainingCommand extends Command
{
    const FILE_NAME = 'planning.ics';

    /**
     * @var Container
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cp:sniffer')
            ->setDescription('Get training plan by url')
            ->addArgument('url', InputArgument::REQUIRED, 'Url of plan.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $jsonString = $this->container->get('cp.parser.plan')->parseToJson($url);

        $plan = $this
            ->container
            ->get('jms.serializer')
            ->deserialize($jsonString, Plan::class, 'json')
        ;

        $calendarStream = $this->container->get('cp.calendar.builder.calendar')->exportCalendar($plan);
        file_put_contents(__DIR__.'/../../../planning.ics', $calendarStream);

        //$output->writeln((string) $plan);
        //$output->writeln($calendarStream);
    }

    /**
     * @param Container $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }
}
