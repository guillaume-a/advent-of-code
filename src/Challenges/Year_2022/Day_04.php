<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_04 extends ChallengeBase {
  
  public function part1(): string {
    $score = 0;
    
    foreach($this->lines as $line) {
      list($s1, $s2) = explode(',', $line);
      $elf1 = explode('-', $s1);
      $elf2 = explode('-', $s2);
      
      $score += (
        //elf 1 contains elf 2 ?
        ($elf1[0] <= $elf2[0] && $elf1[1] >= $elf2[1])
        ||
        //elf 2 contains elf 1 ?
        ($elf2[0] <= $elf1[0] && $elf2[1] >= $elf1[1])
      ) ? 1 : 0;
    }
    
    return (string) $score;
  }

  public function part2(): string {
    $score = 0;

    foreach($this->lines as $line) {
      list($s1, $s2) = explode(',', $line);
      $elf1 = explode('-', $s1);
      $elf2 = explode('-', $s2);

      $score += (
        ($elf1[1] < $elf2[0] || $elf1[0] > $elf2[1])
      ) ? 0 : 1;
    }

    return (string) $score;
  }
}