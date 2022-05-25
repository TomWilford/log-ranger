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
use Symfony\Component\Console\Input\ArrayInput;
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
    private int $switch;

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
            ->addArgument('firstname', InputArgument::REQUIRED, 'Your name please?')
            ->addArgument('lastname', InputArgument::OPTIONAL, 'Your surname too?')
            ->addOption('switch', 's', InputOption::VALUE_NONE, "A switch... Press it?")
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
        $this->name = filter_var($input->getArgument('firstname'), FILTER_SANITIZE_ADD_SLASHES);
        $lastname   = filter_var($input->getArgument('lastname'), FILTER_SANITIZE_ADD_SLASHES);
        if ($lastname) {
            $this->name .= ' ' . $lastname;
        }
        $this->switch = filter_var($input->getOption('switch'), FILTER_VALIDATE_INT);
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

        if (!$this->switch) {
            $output->writeln('No \'switch\' this time?');
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
        // Output feedback
        $output->writeln(['Thanks for that!', 'Now lets see...']);
        $output->writeln('Your name is ' . $this->name. '!');

        $command = $this->getApplication()->find('console:greet');
        $arguments = [
            'name' => $this->name
        ];
        $greetCommandInput = new ArrayInput($arguments);
        try {
            $returnCode = $command->run($greetCommandInput, $output);
        } catch (\Throwable $e) {
            $output->writeln([
                'Whoops, forgot your name there for a second.',
                'Can you tell me again...',
                'But this time try not to' . $e->getMessage(),
                ]);
        }

        if ($returnCode != Command::SUCCESS) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}