<?php

namespace Joky\AdventOfCode\Challenges\Year_2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_04 extends ChallengeBase {

  public function part1(): string {
    $i = 0;
    $private = reset($this->lines);
    do {
      $hash = md5($private . ++$i);
    } while(!str_starts_with($hash, '00000'));

    return $i;
  }

  public function part2(): string {
    $i = 0;
    $private = reset($this->lines);
    do {
      $hash = md5($private . ++$i);
    } while(!str_starts_with($hash, '000000'));

    return $i;
  }
}