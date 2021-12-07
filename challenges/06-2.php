<?php
ini_set('memory_limit', -1);

/*
echo "How many days ? : ";
$handle = fopen ("php://stdin","r");
$daysToCount = (int) fgets($handle);
*/

$daysToCount = 256;

$fishes = array_fill(0, 8, 0);
$line = reset($lines);
echo 'Initial state:  ' . $line . PHP_EOL;
$initValues = explode(',', $line);

foreach($initValues as $value) {
  $fishes[$value]++;
}

$currentDay = 0;

while($currentDay < $daysToCount) {

  $fishToReset = $fishes[0];

  $fishes = [
    $fishes[1],
    $fishes[2],
    $fishes[3],
    $fishes[4],
    $fishes[5],
    $fishes[6],
    $fishes[7],
    $fishes[8],
  ];

  $currentDay++;

  $fishes[6] += $fishToReset;
  $fishes[8] += $fishToReset;
}

return array_sum($fishes);
