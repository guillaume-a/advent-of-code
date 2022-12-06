<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_01 extends ChallengeBase {

  public function part1(): string {
    $greatest = 0;
    $current = 0;
    
    foreach($this->lines as $line) {
      if($line === '') {        
        if($current > $greatest) {
          $greatest = $current;
        }
        $current = 0;
      }

      $current += (int) $line;
    }
    
    return (string) max($current, $greatest);
  }

  public function part2(): string {
    $list = [];
    $current = 0;

    foreach($this->lines as $line) {
      if($line === '') {
        $list[] = $current;
        $current = 0;
      }

      $current += (int) $line;
    }

    $list[] = $current;
    rsort($list);
    $top3 = array_splice($list, 0, 3);
    
    return (string) array_sum($top3);
  }
}