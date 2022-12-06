<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_03 extends ChallengeBase {


  public function part1(): string {
    $score = 0;
    
    foreach($this->lines as $line) {
      $half = strlen($line)/2;
      $c1 = str_split(substr($line, 0, $half)); 
      $c2 = str_split(substr($line, $half));

      $intersect = array_intersect($c1, $c2);
      $common = reset($intersect);
      
      $ord = ord($common);
      
      if($ord >= 97) {
        $score += $ord - 96;
        continue;
      }
      
      $score += $ord - 64 + 26;
      //a=97
      //z=122
      //A=65
      //Z=90
    }
    
    return (string) $score;
  }

  public function part2(): string {
    $score = 0;
    
    $rucksacks = array_map(function($i){return str_split($i);}, $this->lines);
    $groups = array_chunk($rucksacks, 3);

    foreach ($groups as $group) {
      $intersect = array_intersect($group[0], $group[1], $group[2]);
      $common = reset($intersect);

      $ord = ord($common);

      if($ord >= 97) {
        $score += $ord - 96;
        continue;
      }

      $score += $ord - 64 + 26;      
    }
    
    return (string) $score;
  }
}