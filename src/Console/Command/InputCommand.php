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
            ->addOption('option', 'o', InputOption::VALUE_NONE, "An optional option.")
        ;
    }

    /**
     * Runs logic and can output messages when command is called.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Thanks for that!', 'Now lets see...']);

        $output->writeln('Your name is ' . $input->getArgument('name') . '!');

        return Command::SUCCESS;
    }
}