<?php

$x = 0;
$y = 0;

foreach($lines as $line) {
  list($command, $force) = explode(' ', $line);

  switch ($command) {
    case 'forward':
      $x += $force;
      break;
    case 'down':
      $y += $force;
      break;
    case 'up':
      $y -= $force;
      break;
  }
}

return $x * $y;