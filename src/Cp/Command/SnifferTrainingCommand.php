<?php

namespace Cp\Command;

use Cp\DomainObject\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
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
            ->addArgument('week', InputArgument::OPTIONAL, 'Number of week', 6)
            ->addArgument('seance', InputArgument::OPTIONAL, 'Number of seance', 3)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $week = $input->getArgument('week');
        $seance = $input->getArgument('seance');

        $typeOfPlan = $this->container->get('cp.provider.type')->getAllName();
        $question = new ChoiceQuestion('Please select a plan', $typeOfPlan, 0);
        $question->setErrorMessage('Plan %s is not valid.');

        $helper = $this->getHelper('question');
        $typeName = $helper->ask($input, $output, $question);
        $type = $this->container->get('cp.provider.type')->getTypeByName($typeName);

        $configuration = new Configuration();
        $configuration->setType($type);
        $configuration->setNumberOfWeek($week);
        $configuration->setNumberOfSeance($seance);

        $plan = $this->container->get('cp.provider.plan')->getPlanByConfiguration($configuration);
        $plan->setConfiguration($configuration);

        $calendarStream = $this
            ->container
            ->get('cp.calendar.builder.calendar')
            ->exportCalendar($plan);

        file_put_contents(
            __DIR__.'/../../../'.$this->container->get('cocur.slugify')->slugify($plan->getName()).'.ics',
            $calendarStream
        );
    }

    /**
     * @param Container $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }
}
