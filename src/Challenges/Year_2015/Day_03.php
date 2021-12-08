<?php

namespace Joky\AdventOfCode\Challenges\Year_2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_03 extends ChallengeBase {

  public function part1(): string {
    $houses = ['0-0'];
    $x = 0;
    $y = 0;

    foreach(str_split(reset($this->lines)) as $direction) {
      switch ($direction) {
        case '^': $y--; break;
        case 'v': $y++; break;
        case '<': $x--; break;
        case '>': $x++; break;
      }
      $coords = $x . '-' . $y;
      $houses[] = $coords;
    }

    return count(array_unique($houses));
  }

  public function part2(): string {
    $houses = ['0-0'];

    $turn = 0;
    $positions = [
      ['x' => 0, 'y' => 0],
      ['x' => 0, 'y' => 0]
    ];

    foreach(str_split(reset($this->lines)) as $direction) {

      $x = $positions[$turn]['x'];
      $y = $positions[$turn]['y'];

      switch ($direction) {
        case '^': $y--; break;
        case 'v': $y++; break;
        case '<': $x--; break;
        case '>': $x++; break;
      }

      $positions[$turn] = ['x' => $x, 'y' => $y];

      $coords = $x . '-' . $y;
      $houses[] = $coords;

      $turn++;
      if($turn === 2) $turn = 0;
    }

    return count(array_unique($houses));
  }
}