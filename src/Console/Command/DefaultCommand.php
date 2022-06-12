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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * DefaultCommand is an example of overwriting the application's output when called without a command.
 *
 * Please Note: This file is intended as a template for development and should be overwritten before deployment.
 *
 * @author Tom Wilford <hello@jollyblueman.com>
 */
class DefaultCommand extends ConsoleCommand
{
    protected static $defaultName = 'console:default';
    protected static $defaultDescription = 'An introduction to Console.';

    protected function configure()
    {
        $this->setDescription('Outputs an introduction to Console.')
            ->setHidden(true)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Welcome to Console');

        $io->section('About');
        $io->text('Console is a starting point for command line applications.');
        $io->newLine();
        $io->text('The aim of this project is to provide:');
        $io->listing([
            'A ready-made file structure',
            'Examples of features in use',
            'Examples of best practices'
        ]);

        $io->section('Commands');
        $listCommand = $this->getApplication()->find('list');
        $listCommandArguments = new ArrayInput([
           'namespace' => 'console',
           '--format' => 'txt',
           '--raw' => true,
        ]);
        $returnCode = Command::SUCCESS;
        try {
            $returnCode = $listCommand->run($listCommandArguments, $output);
        } catch (\Throwable $exception) {
            $output->writeln([
                'Error listing commands: ' . $exception->getCode(),
                $exception->getMessage()
            ]);
            if ($returnCode != Command::SUCCESS) {
                return Command::FAILURE;
            }
        }
        $io->newLine();

        return Command::SUCCESS;
    }
}
