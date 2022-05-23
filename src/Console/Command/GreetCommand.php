<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Wilf\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand; // php ^8 syntax attributes
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * GreetCommand is simple command example using ^php8 attributes.
 *
 * AsCommand() allows you to set:
 *      - name        = Defines how the command is called.
 *      - description = Used to explain the command in help pages.
 *      - aliases     = Alternative ways of calling the command.
 *      - hidden      = Visibility of the command in help pages.
 *
 * @author Tom Wilford <hello@jollyblueman.com>
 */
#[AsCommand(
    name: 'console:greet',
    description: 'Greets you, warmly.',
    aliases: ['console:ahoy'],
    hidden: false
)]
class GreetCommand extends ConsoleCommand
{
    /**
     * Sets further info about the command and enables user input.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setHelp('It\'s just a greeting, no obligation!');
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
        $section = $output->section();
        $section->write('Hello there!');

        return Command::SUCCESS;
    }
}