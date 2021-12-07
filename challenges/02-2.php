<?php

$x = 0;
$y = 0;
$aim = 0;

foreach($lines as $line) {
  list($command, $force) = explode(' ', $line);

  switch ($command) {
    case 'forward':
      $x += $force;
      $y += $aim * $force;
      break;
    case 'down':
      $aim += $force;
      break;
    case 'up':
      $aim -= $force;
      break;
  }
}

return $x * $y;