<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/inputs/input-01-1.txt'));

$increased = 0;
$previous = PHP_INT_MAX;

foreach($lines as $line) {
  if($line > $previous) {
    $increased++;
  }

  $previous = $line;
}

echo $increased;