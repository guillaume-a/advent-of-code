<?php

function get_most_common_bit($lines, $position) {
  $half = count($lines) * .5;
  $sum = 0;

  foreach($lines as $line) {
    $bits = str_split($line);
    $sum += $bits[$position];
  }

  return $sum >= $half ? '1' : '0';
}

function invert($bit) {
  return $bit === '1' ? '0' : '1';
}

function calculate_oxygen_rating($lines) {

  $size = strlen($lines[0]);

  $mask = '';

  for($i=0;$i<$size;$i++) {
    $mask .= get_most_common_bit($lines, $i);
    $keep = [];

    foreach($lines as $line) {
      if(preg_match('/^' . $mask . '/', $line)) {
        $keep[] = $line;
      }
    }

    if(count($keep) === 1) {
      return reset($keep);
    }

    $lines = $keep;
  }

  return 0;
}

function calculate_co2_rating($lines) {

  $size = strlen($lines[0]);

  $mask = '';

  for($i=0;$i<$size;$i++) {
    $mask .= invert(get_most_common_bit($lines, $i));
    $keep = [];

    foreach($lines as $line) {
      if(preg_match('/^' . $mask . '/', $line)) {
        $keep[] = $line;
      }
    }

    if(count($keep) === 1) {
      return reset($keep);
    }

    $lines = $keep;
  }

  return 0;
}

$oxygen = calculate_oxygen_rating($lines);
$co2 = calculate_co2_rating($lines);

echo bindec($oxygen) * bindec($co2);
