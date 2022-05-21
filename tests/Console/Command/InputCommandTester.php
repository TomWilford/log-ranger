<?php

namespace Wilf\Tests\Console\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class InputCommandTester extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('console:input');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'name' => 'Tom',
            '--option' => 'Yes'
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Your name is Tom!', $output);
    }
}