<?php

namespace Wilf\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand; // php ^8 syntax attributes
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php ^8 syntax attributes
#[AsCommand(
    name: 'console:greet',
    description: 'Greets you, warmly.',
    aliases: ['console:ahoy'],
    hidden: false
)]
class GreetCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this->setHelp("It's just a greeting, no obligation!");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Hello there!");

        return Command::SUCCESS;
    }
}