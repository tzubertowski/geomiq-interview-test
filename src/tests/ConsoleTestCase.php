<?php

namespace Tests;

use Illuminate\Console\Command;
use Symfony\Component\Console\Tester\CommandTester;

abstract class ConsoleTestCase extends TestCase
{
    protected function runCommand(Command $command, array $arguments = [], array $interactiveInput = []): CommandTester
    {
        $command->setLaravel($this->app);
        $tester = new CommandTester($command);
        $tester->setInputs($interactiveInput);
        $tester->execute($arguments);

        return $tester;
    }
}