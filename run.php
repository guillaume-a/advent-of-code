#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Joky\AdventOfCode\Command\RunCommand;
use Symfony\Component\Console\Application;

$application = new Application('aoc', '1.0.0');

$command = new RunCommand();

$application->add($command);
$application->setDefaultCommand($command->getName(), true);

try {
    $application->run();
} catch (Exception $e) {
    echo 'Error while launching command.' . PHP_EOL;
    exit;
}