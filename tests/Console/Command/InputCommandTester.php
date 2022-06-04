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
            ->addArgument('Tom') // name
            ->addOption('switch')
            ->addOption('number', '10')
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Hello there Tom!')
            ->assertOutputContains('10')
        ;

        TestCommand::from($app, 'console:input')
            ->splitOutputStreams()
            ->addArgument('Tom') // name
            ->addArgument('wilford') // lastname
            ->addOption('number', 16)
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Hello there Tom Wilford!')
            ->assertOutputContains('16')
        ;

        TestCommand::from($app, 'console:input')
            ->splitOutputStreams()
            ->addArgument('Tom') // name
            ->addArgument('wilford') // lastname
            ->addArgument('php') // languages[]
            ->addArgument('html') // languages[]
            ->addArgument('css') // languages[]
            ->addOption('number', '419')
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Hello there Tom Wilford!')
            ->assertOutputContains('So you like php, html and css?')
            ->assertOutputContains('419')
        ;

        TestCommand::from($app, 'console:input')
            ->splitOutputStreams()
            ->addArgument('Tom') // name
            ->addArgument('wilford') // lastname
            ->addArgument('php') // languages[]
            ->addArgument('css') // languages[]
            ->addOption('number', '89')
            ->addOption('waffle', 'no')
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Name: Tom wilford')
            ->assertOutputContains('Languages: php and css')
            ->assertOutputContains('Number: 89')
        ;
    }
}