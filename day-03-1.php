<?php

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/inputs/input-03-1.txt'));

$first = true;
$sums = [];
$half = count($lines) * .5;

$epsylon = '';
$gamma = '';

foreach($lines as $line) {
  $bits = str_split($line);
  $size = count($bits);

  //Avoid undefined indexes
  if($first) {
    $sums = array_fill(0, $size, 0);
    $first = false;
  }

  foreach($bits as $position => $value) {
    $sums[$position] += (int) $value;
  }
}

foreach($sums as $value) {
  $most_common = ($value > $half) ? '1' : '0';
  $least_common = ($value > $half) ? '0' : '1';

  $epsylon .= $most_common;
  $gamma .= $least_common;
}

echo bindec($epsylon) * bindec($gamma);
