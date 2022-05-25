<?php

namespace Wilf\Tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Wilf\Console\Command\GreetCommand;
use Wilf\Console\Command\InputCommand;
use Zenstruck\Console\Test\TestCommand;

class InputCommandTester extends TestCase
{
    public function testExecute()
    {
        $app = new Application();
        $app->add(new GreetCommand()); // php run console:greet
        $app->add(new InputCommand()); // php run console:input

        TestCommand::from($app, 'console:input')
            ->splitOutputStreams()
            ->addArgument('Tom')
            ->addOption('switch')
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Your name is Tom!')
        ;

        TestCommand::from($app, 'console:input')
            ->splitOutputStreams()
            ->addArgument('Tom')
            ->addArgument('wilford')
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Hello there Tom Wilford!')
        ;
    }
}