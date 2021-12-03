<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/inputs/input-01-1.txt'));

//Calculate sums
$sums = [];

foreach($lines as $index => $line) {
  if(!array_key_exists($index, $sums)) {
    $sums[$index] = 0;
  }

  $sums[$index] += (int) $line;

  if($index >= 1) {
    $sums[$index-1] += (int) $line;
  }
  if($index >= 2) {
    $sums[$index-2] += (int) $line;
  }
}

//calculate increased count
$increased = 0;
$previous = PHP_INT_MAX;

foreach($sums as $line) {
  if($line > $previous) {
    $increased++;
  }

  $previous = $line;
}

echo $increased;