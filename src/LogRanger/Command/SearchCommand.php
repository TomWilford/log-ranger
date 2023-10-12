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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomWilf\LogRanger\Input\Validator;
use TomWilf\LogRanger\Search\Paths\Paths;
use TomWilf\LogRanger\Search\Search;
use TomWilf\LogRanger\Search\ValidateInput;

class SearchCommand extends ConsoleCommand
{
    protected static $defaultName = "log-ranger:search";
    protected static $defaultDescription = "Begin search of a file";
    private $path;
    private $startDate;
    private $endDate;
    private $outputFormat;

    private $search;

    protected function configure()
    {
        $this->setHelp("Searching requires a path and/or a start & end date.")
            ->setHidden(false)
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Paths to log file/folder'
            )
            ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $validator = new Validator();
        $validator->execute();
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$this->path) {
            $io = new SymfonyStyle($input, $output);
            $io->section("* Log Ranger *");
            $io->text("A pleasure to make your acquaintance.");
            $answer = $io->ask("Where would you like me to search?", "/var/log/");
            if ($answer = ValidateInput::path($answer)) {
                $this->path = $answer;
                $io->text("Alright. I'll start looking in " . $answer[0]);
            } else {
                $io->text("Listen partner, you need to give me more to go on.");
            }

            $answer = $io->confirm("Shall I show you the ropes, partner?", false);
            if (!$answer = filter_var($answer, FILTER_VALIDATE_BOOL)) {
                $io->text("Suit yourself partner.");
            } else {
                $io->text("Well alright, buckle up.");
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->path;

        $io = new SymfonyStyle($input, $output);
        $io->text("Beginning search in: " . $path[0]);

        return Command::SUCCESS;
    }
}