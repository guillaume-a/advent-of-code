<?php

namespace Joky\AdventOfCode\Challenges\Year_2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_01 extends ChallengeBase {

  public function part1(): string {
    $increased = 0;
    $previous = PHP_INT_MAX;

    foreach($this->lines as $line) {
      if($line > $previous) {
        $increased++;
      }

      $previous = $line;
    }

    return $increased;
  }

  public function part2(): string {
    //Calculate sums
    $sums = [];

    foreach($this->lines as $index => $line) {
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

    return $increased;
  }
}