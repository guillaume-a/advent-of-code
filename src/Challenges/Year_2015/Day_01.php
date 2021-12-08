<?php

namespace Joky\AdventOfCode\Challenges\Year_2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_01 extends ChallengeBase {

  public function part1(): string {
    $directions = str_split($this->lines[0]);

    $floor = 0;

    foreach($directions as $direction) {
      $floor += $direction === '(' ? 1 : -1;
    }

    return $floor;
  }

  public function part2(): string {
    $directions = str_split($this->lines[0]);

    $floor = 0;

    foreach($directions as $position => $direction) {
      $floor += $direction === '(' ? 1 : -1;

      if($floor === -1) {
        return $position + 1;
      }
    }
  }
}