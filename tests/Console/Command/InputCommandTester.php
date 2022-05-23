<?php

namespace Wilf\Tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Wilf\Console\Command\GreetCommand;
use Wilf\Console\Command\InputCommand;
use Zenstruck\Console\Test\TestCommand;

class InputCommandTester extends TestCase
{
    public function testExecute()
    {
        TestCommand::for(new InputCommand())
            ->execute('Tom --option')
            ->assertSuccessful()
            ->assertOutputContains('Your name is Tom!')
        ;
    }
}