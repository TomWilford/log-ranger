<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * DefaultCommand is a splash page for the application.
 *
 * @author Tom Wilford <hello@jollyblueman.com>
 */
class DefaultCommand extends ConsoleCommand
{
    protected static $defaultName = 'log-ranger:default';
    protected static $defaultDescription = 'An introduction to Log Ranger.';

    protected function configure()
    {
        $this->setDescription('Outputs an introduction to Log Ranger.')
            ->setHidden(true)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Welcome to Log Ranger');

        $io->section('About');
        $io->text('Log Ranger locates log messages in a date range.');
        $io->newLine();

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
