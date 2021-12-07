<?php

$increased = 0;
$previous = PHP_INT_MAX;

foreach($lines as $line) {
  if($line > $previous) {
    $increased++;
  }

  $previous = $line;
}

return $increased;