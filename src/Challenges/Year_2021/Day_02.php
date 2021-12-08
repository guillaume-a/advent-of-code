<?php

namespace Joky\AdventOfCode\Challenges\Year_2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_02 extends ChallengeBase {

  public function part1(): string {
    $x = 0;
    $y = 0;

    foreach($this->lines as $line) {
      list($command, $force) = explode(' ', $line);

      switch ($command) {
        case 'forward':
          $x += (int) $force;
          break;
        case 'down':
          $y += (int) $force;
          break;
        case 'up':
          $y -= (int) $force;
          break;
      }
    }

    return (string) $x * $y;
  }

  public function part2(): string {

    $x = 0;
    $y = 0;
    $aim = 0;

    foreach($this->lines as $line) {
      list($command, $force) = explode(' ', $line);

      switch ($command) {
        case 'forward':
          $x += (int) $force;
          $y += $aim * (int) $force;
          break;
        case 'down':
          $aim += (int) $force;
          break;
        case 'up':
          $aim -= (int) $force;
          break;
      }
    }

    return (string) $x * $y;
  }
}