<?php

namespace Wilf\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

class InputCommand extends ConsoleCommand
{
    protected static $defaultName = "console:input";
    protected static $defaultDescription = "Example command with inputs.";

    protected function configure()
    {
        $this->setHelp("Let me figure out the options first")
            ->setHidden(false)
            ->setAliases(["console:test"])
            ->addArgument('name', InputArgument::REQUIRED, 'Your name please?')
            ->addOption('option', 'o', InputArgument::OPTIONAL, "An optional option.");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Thanks for that!', 'Now lets see...']);

        $output->writeln('Your name is ' . $input->getArgument('name') . '!');

        return Command::SUCCESS;
    }
}