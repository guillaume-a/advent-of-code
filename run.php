#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Joky\AdventOfCode\Command\NewCommand;
use Joky\AdventOfCode\Command\RunCommand;
use Symfony\Component\Console\Application;

$application = new Application('aoc', '1.1.0');

$application->addCommand(new RunCommand());
$application->addCommand(new NewCommand());
$application->setDefaultCommand('aoc:run');

try {
    $application->run();
} catch (Exception $e) {
    echo 'Error while launching command.' . PHP_EOL;
    exit;
}