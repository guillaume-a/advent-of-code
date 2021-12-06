<?php

if($argc < 2) {
  throw new Exception("You must select a day to execute.");
}

$day = $argv[1];
$input = ($argc < 3) ? 'example' : $argv[2];

// Of course it's not secure, it's not hosted on any server...
$inputFile = __DIR__ . '/inputs/' . substr($day, 0, 2) . '-' . $input . '.txt';
$challengeFile = __DIR__ . '/challenges/' . $day . '.php';

if( !file_exists($inputFile)) {
  throw new Exception('Input file not found : ' . $inputFile);
}

if( !file_exists($challengeFile)) {
  throw new Exception('Challenge file not found : ' . $challengeFile);
}

$lines = explode(PHP_EOL, file_get_contents($inputFile));

require_once $challengeFile;