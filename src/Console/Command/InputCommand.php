<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Wilf\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * InputCommand is an example of different inputs in use.
 *
 * @author Tom Wilford <hello@jollyblueman.com>
 */
class InputCommand extends ConsoleCommand
{
    /**
     * Defines how the command is called.
     *
     * @var string
     */
    protected static $defaultName = "console:input";

    /**
     * Used to explain the command in help pages.
     *
     * Set here, instead of in configure(), for performance.
     *
     * @var string
     */
    protected static $defaultDescription = "Example command with inputs.";

    private string $name;
    protected int $switch;

    /**
     * Sets further info about the command and enables user input.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setHelp("Let me figure out the options first")
            ->setHidden(false)
            ->setAliases(["console:test"])
            ->addArgument('name', InputArgument::REQUIRED, 'Your name please?')
            ->addOption('switch', 's', InputOption::VALUE_NONE, "An optional option.")
        ;
    }

    /**
     * Executes first.
     * Initialises variables used in the rest of the command methods.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->name   = $input->getArgument('name') ?? "";
        $this->switch = $input->getOption('switch') ?? 0;
    }

    /**
     * Executes second.
     * Used to check if the options/arguments are set, and ask for them. After this point
     * missing options/arguments cause an error.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (!$this->name) {
            $output->writeln('Your name is required for me to repeat it back to you.');
        }

        if ($this->switch == 0) {
            $output->writeln('No option?');
        }
    }

    /**
     * Executes last.
     * Runs logic and can output messages when command is called. Must return an integer.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Thanks for that!', 'Now lets see...']);

        $output->writeln('Your name is ' . $this->name. '!');

        return Command::SUCCESS;
    }
}