<?php

$values = explode(',', reset($lines));

// How to Calculate Percentile
// https://www.wikiwand.com/en/Percentile

// The nearest-rank method
// Sort dataset
sort($values);

//Calculate the rank r for the percentile p
$n = count($values);
$p = 50;
$r = ($p / 100) * ($n - 1) + 1;

$percentile = $values[floor($r)];

$fuel = array_reduce($values, function($fuel, $position) use ($percentile) {
  return $fuel + abs($position - $percentile);
}, 0);

return $fuel;
