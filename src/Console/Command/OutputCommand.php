<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace Wilf\Console\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wilf\Console\Command\ConsoleCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * OutputCommand is an example of advanced output styling.
 *
 * Please Note: This file is intended as a reference for development and should be removed before deployment.
 *
 * @author Tom Wilford <hello@jollyblueman.com>
 */
class OutputCommand extends ConsoleCommand
{
    /**
     * Defines how the command is called.
     *
     * @var string
     */
    protected static $defaultName = 'console:output';
    /**
     * Used to explain the command in help pages.
     *
     * @var string
     */
    protected static $defaultDescription = "An example of advanced output.";

    /**
     * Sets further info about the command and can enable user input.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setHelp('The command will just output fancy stuff.')
            ->setHidden(false)
            ->setAliases(['console:fancy']);
    }

    /**
     * Runs logic and can output messages when command is called. Must return an integer.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Welcome to console:output!!!1!');

        $io->section('We got Sections...');
        $io->text('Kind of like a subtitle');
        $io->text([
            'So you can do a group of actions...',
            'and then move on to something like..'
        ]);

        $io->section('Listings!');
        $io->listing([
            'Listings are great',
            'They\'re just unordered lists',
            'Perfect for listing things out',
            'Not great for structured data but...'
        ]);

        $io->section('We got Tables!');
        $io->text('The classic table:');
        $io->table(
            ['Header A', 'Header B'],
            [
                ['Cell A1', 'Cell B1'],
                ['Cell A2', 'Cell B2'],
                ['Cell A3', 'Cell B3'],
            ]
        );
        $io->text('The horizontal table:');
        $io->horizontalTable(
            ['Header A', 'Header B'],
            [
                ['Cell A1', 'Cell B1'],
                ['Cell A2', 'Cell B2'],
                ['Cell A3', 'Cell B3'],
            ]
        );
        $io->text('The definition list:');
        $io->definitionList(
            'Languages',
            ['php' => 'PHP: Hypertext Preprocessor'],
            ['css' => 'Cascading Style Sheets'],
            ['html' => 'Hypertext Markup Language'],
            ['json' => 'JavaScript Object Notation'],
            new TableSeparator(),
            'Other Stuff',
            ['api' => 'application programming interface']
        );
        $io->text('The "dynamic" table:');
        $table = $io->createTable();
        $table->setHeaders(['Header A', 'Header B']);
        $table->setHeaderTitle('So _dynamic_');
        $table->addRow(['Cell A1', 'Cell B1']);
        $table->render();
        $io->text('One row added...');
        sleep(.5);
        $io->newLine(3);
        $table->addRows([
            ['Cell A2', 'Cell B2'],
            ['Cell A3', 'Cell B3'],
        ]);
        $table->render();
        $io->text('Two rows added...');
        $io->newLine();
        $io->text('Next up we have...');

        $io->section('Admonitions');
        $io->text('The note');
        $io->note('This is what a note looks like');
        $io->note([
            'It should be used sparingly',
            'lest it clutter the output'
        ]);

        $io->text('The caution');
        $io->caution('Tread _cautiously_, here there be dragons');
        $io->caution([
            'also the message looks like an error',
            'so use sparingly',
            'lest ye scare the user'
        ]);

        $io->section('Progress Bar');
        $io->text('Progress with known length');
        $io->progressStart(2);
        sleep(1.25);
        $io->progressAdvance();
        sleep(1.25);
        $io->progressFinish();
        $io->text('Progress with unknown length');
        $io->progressStart();
        sleep(1.25);
        $io->progressAdvance();
        sleep(1.25);
        $io->progressFinish();
        $io->text('Progress with an iterable');
        $array = [1.25, 1.25, 1.25];
        foreach ($io->progressIterate($array) as $value) {
            sleep((int)$value);
        }
        $io->text('Custom progress bar');
        $bar = $io->createProgressBar(3);
        $bar->setBarCharacter('#');
        $bar->setEmptyBarCharacter('~');
        $bar->setBarWidth(100);
        $bar->setRedrawFrequency(1);
        $bar->start();
        $bar->display();
        $io->text("Started at: " . (new \DateTime('@' . $bar->getStartTime()))->format('Y-m-d H:i:s'));
        sleep(1);
        $io->text("Estimated: " . $this->createEstimate($bar->getStartTime(), $bar->getEstimated()));
        $bar->advance(1);
        sleep(1);
        $io->text("Estimated: " . $this->createEstimate($bar->getStartTime(), $bar->getEstimated()));
        $bar->advance(1);
        sleep(1);
        $io->text("Estimated: " . $this->createEstimate($bar->getStartTime(), $bar->getEstimated()));
        $bar->finish();
        $io->text("Finished at: " . (new \DateTime('now'))->format('Y-m-d H:i:s'));

        $io->section('Interactive Input');
        $io->text('Normal question/answer');
        $answer = $io->ask('Do androids dream of electric sheep?', 'Probably');
        if ($answer = filter_var($answer, FILTER_SANITIZE_ADD_SLASHES)) {
            $message = str_contains($answer, 'Probably') ? 'I think so too' : 'Interesting';
            $io->text($message);
        }
        $io->newLine(2);
        $io->text('Question with hidden answer (think passwords)');
        $password = $io->askHidden('What\'s the worst password you can think of?', function ($password) {
            if (!$password = filter_var($password, FILTER_SANITIZE_ADD_SLASHES)) {
                throw new \RuntimeException('Error occurred processing password');
            }

            return $password;
        });
        if ($password) {
            $io->text('Agreed, that\'s bad');
        }
        $io->newLine(2);
        $io->text('Yes/No question');
        $confirm = $io->confirm('Do you like php?', true);
        $message = $confirm ? 'I like php too.' : 'Fair enough, I don\'t blame you.';
        $io->text($message);
        $io->newLine(2);
        $io->text('Multiple choice');
        $choice = $io->choice('Which one is best?', ['php', 'node.js', 'java', 'python'], 'php');
        $io->text($choice);
        $message = $choice == "php" ? 'Give one of the others a go anyway!' : 'I\'ll take your word for it!';
        $io->text($message);

        $io->text('And finally...');
        $io->section('Result Methods');
        $io->text('Success');
        $io->success('Hooray, the job completed successfully');
        $io->text('Info');
        $io->info('The job completed faster than expected too');
        $io->text('Warning');
        $io->warning('Hang on... the job didn\'t complete...');
        $io->text('Error');
        $io->error([
            'Yep. Turns out the job didn\'t complete...',
            '...and System32 has been deleted.',
            'Sorry about that!'
        ]);

        return Command::SUCCESS;
    }

    /**
     * Turns the estimated amount of time till completion into a nice string.
     *
     * @param $startTime
     * @param $estimate
     * @return string
     */
    private function createEstimate($startTime, $estimate): string
    {
        $result = "N/A";
        try {
            $start = (new \DateTime('@' . $startTime));
            $interval = new \DateInterval('PT' . $estimate . 'S');
            if ($start->add($interval)) {
                $result = $start->format('Y-m-d H:i:s');
            }
        } catch (Exception $e) {
            $result = "Error processing estimate: " . $e->getCode();
        }

        return $result;
    }
}
