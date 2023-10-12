<?php

namespace TomWilf\Tests\LogRanger\Command;

use PHPUnit\Framework\TestCase;
use TomWilf\LogRanger\Command\GreetCommand;
use Zenstruck\Console\Test\TestCommand;

class GreetCommandTester extends TestCase
{
    public function testExecute()
    {
        TestCommand::for(new GreetCommand())
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('Hello there!')
        ;
    }
}