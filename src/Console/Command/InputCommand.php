<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Wilf\Console\Command;

use SebastianBergmann\CodeCoverage\Report\PHP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Command\LockableTrait;

/**
 * InputCommand is an example of different inputs in use.
 *
 * Please Note: This file is intended as a reference for development and should be removed before deployment.
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
    private string $languages;
    private int $switch;
    private int $number;
    private bool $waffle;

    /**
     * Sets further info about the command and enables user input.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setHelp("It's just a random bunch of questions really!")
            ->setHidden(false)
            ->setAliases(["console:test"])
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Your firstname please?'
            )
            ->addArgument(
                'lastname',
                InputArgument::OPTIONAL,
                'Your surname too? Your choice!'
            )
            ->addArgument(
                'languages',
                 InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
                'Your favourite languages?'
            )
            ->addOption(
                'switch',
                's',
                InputOption::VALUE_NONE,
                "A switch... Press it?"
            )
            ->addOption(
                'number',
                '#',
                InputOption::VALUE_REQUIRED,
                'Your favourite number?',
            )
            ->addOption(
                'waffle',
                'w',
                InputOption::VALUE_OPTIONAL,
                'Do you want waffle with your output?',
                false
            )
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
        $this->name = filter_var($input->getArgument('name'), FILTER_SANITIZE_ADD_SLASHES);
        if ($lastname = filter_var($input->getArgument('lastname'), FILTER_SANITIZE_ADD_SLASHES)) {
            $this->name .= ' ' . $lastname;
        }

        $languages = filter_var_array($input->getArgument('languages'), FILTER_SANITIZE_ADD_SLASHES);
        if ($languages && count($languages) == 1) {
            $this->languages = $languages[0];
        } else if ($languages && count($languages) == 2) {
            $this->languages = $languages[0] . ' and ' . $languages[1];
        } else {
            $this->languages =
                $languages ?
                    substr_replace(
                        $string = implode(', ', $languages),
                        ' and',
                        strpos($string, ',', (strlen($languages[count($languages) - 1]) + 1)),
                        1
                    ) :
                    false
            ;
        }

        $this->switch = filter_var($input->getOption('switch'), FILTER_VALIDATE_INT);
        $this->number = filter_var($input->getOption('number'), FILTER_VALIDATE_INT);

        // How to handle InputOption::VALUE_OPTIONAL
        $waffle = $input->getOption('waffle');
        if (false === $waffle) {
            // Option not passed
            // Didn't know they could specify... probably want waffle!
            $this->waffle = true;
        } elseif (null === $waffle) {
            // Option passed with no value
            // Knew they could specify but didn't say no... probably want waffle!!
            $this->waffle = true;
        } else {
            // Option passed with values
            // Anything other than no must mean waffle!!!
            $this->waffle = true;
            if ('no' === strtolower($waffle)) {
                $this->waffle = false;
            }
        }
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
        $waffle = $this->waffle;

        // Creating a custom style for output called 'php'
        $outputStyle = new OutputFormatterStyle('#4F5B93', '#8892BF', ['bold', 'blink']);
        $output->getFormatter()->setStyle('php', $outputStyle);

        if (!$this->name && $waffle) {
            $output->writeln('<info>Your name is required for me to repeat it back to you.</info>');
        }

        if ($this->languages && $waffle) {
            if (str_contains($this->languages, 'php')) {
                $output->writeln('<php>A fine choice of languages!</php>');
            }
        }

        if (!$this->switch && $waffle) {
            $output->writeln('<comment>No \'switch\' this time? No problem!</comment>');
        }

        if (!$this->number && $waffle) {
            $output->writeln(['<question>Go on, what\' your favourite number?</question>']);
        }

        if (!$this->waffle) {
            $output->writeln('<error>No waffle? Really? :(</error>');
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
        $waffle    = $this->waffle;
        $name      = $this->name;
        $number    = $this->number;
        $switch    = $this->switch;;
        $languages = $this->languages;

        if ($waffle) {
            $output->writeln(['Thanks for that!', 'Now lets see...']);
        }

        $message = $waffle ? '<question>Your name is "' . $name . '"?</question>' : 'Name: ' . $name;
        $output->writeln($message);

        if ($waffle) {
            $greetCommand = $this->getApplication()->find('console:greet');
            $greetCommandInput = new ArrayInput([
                'name' => $name
            ]);

            // Calling console:greet to say hello
            $returnCode = Command::SUCCESS;
            try {
                // Replace $output below with new NullOutput() to suppress the command's output
                $returnCode = $greetCommand->run($greetCommandInput, $output);
            } catch (\Throwable $e) {
                $output->writeln([
                    '<error>Whoops, forgot your name there for a second.</error>',
                    '<error>Can you tell me again...</error>',
                    '<error>But this time try not to: </error>' . PHP_EOL . $e->getMessage(),
                ]);
            }
            if ($returnCode != Command::SUCCESS) {
                return Command::FAILURE;
            }
        }

        $message = $waffle ? '<comment>' . $number . ', eh? That\'s a good one.</comment>' : 'Number: ' . $number;
        $output->writeln($message);

        if ($switch) {
            $message = $waffle ? '<comment>Ah, and you found the switch.</comment>' : 'Switch: Found';
            $output->writeln($message);
        }

        if ($languages) {
            $message = $waffle ? '<question>So you like ' .$languages . '?</question>' : 'Languages: ' . $languages;
            $output->writeln($message);
        }

        // Example of a clickable link
        $output->writeln([
            '<info>Have you heard of this: <href=https://php.net>php.net</>?</info>',
            '<comment>I think you\'ll love it!</comment>'
        ]);

        return Command::SUCCESS;
    }
}
