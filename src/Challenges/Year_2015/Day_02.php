<?php

namespace Joky\AdventOfCode\Challenges\Year_2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_02 extends ChallengeBase {

  public function part1(): string {
    $total = 0;

    foreach($this->lines as $line) {
      list($l, $w, $h) = explode('x', $line);

      $total += 2*$l*$w + 2*$w*$h + 2*$h*$l;
      $total += min($l*$w, $w*$h, $h*$l);
    }

    return $total;
  }

  public function part2(): string {
    $total = 0;

    foreach($this->lines as $line) {
      $sides = explode('x', $line);
      sort($sides);

      $side1 = array_shift($sides);
      $side2 = array_shift($sides);
      $side3 = array_shift($sides);

      $total += 2*$side1 + 2*$side2;
      $total += $side1 * $side2 * $side3;
    }

    return $total;
  }
}