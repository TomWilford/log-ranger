<?php

namespace Wilf\Tests\Console\Command;
use PHPUnit\Framework\TestCase;
use Wilf\Console\Command\GreetCommand;
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