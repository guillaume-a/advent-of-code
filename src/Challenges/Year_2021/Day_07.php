<?php

namespace Joky\AdventOfCode\Challenges\Year_2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_07 extends ChallengeBase {

  public function part1(): string {

    $values = explode(',', reset($this->lines));

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

    return array_reduce($values, function($fuel, $position) use ($percentile) {
      return $fuel + abs($position - $percentile);
    }, 0);

  }

  public function part2(): string {

    $values = explode(',', reset($this->lines));

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

    return $min_fuel;

  }
}