<?php

$values = explode(',', reset($lines));

$min_fuel = PHP_INT_MAX;

//brute force, did not find the algo
for ($destination = 0;$destination < count($values); $destination++) {
  $fuel = array_reduce($values, function($global_fuel, $position) use ($destination) {
    $distance = abs($position - $destination);
    $fuel = ($distance * ($distance + 1)) / 2;
    return $global_fuel + $fuel;
  }, 0);

  $min_fuel = min($min_fuel, $fuel);
}


var_dump($min_fuel);
