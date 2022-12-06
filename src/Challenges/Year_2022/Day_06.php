<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_06 extends ChallengeBase {

  public function part1(): string {
    $line = reset($this->lines);
    
    for($i=0;$i<strlen($line)-4;$i++) {
      $marker = str_split(substr($line, $i, 4));
      $digits = array_unique($marker);
      if(count($digits) === 4) {
        return (string) ($i+4);
      }
    }
    
    return '0';
  }

  public function part2(): string {
    $line = reset($this->lines);

    for($i=0;$i<strlen($line)-14;$i++) {
      $marker = str_split(substr($line, $i, 14));
      $digits = array_unique($marker);
      if(count($digits) === count($marker)) {
        return (string) ($i+14);
      }
    }

    return '0';
  }
}