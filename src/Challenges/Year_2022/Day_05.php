<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_05 extends ChallengeBase {
  private $moves = [];
  private $stacks = [];
  
  private function init() {
    $step = 'stacks';
    
    foreach($this->lines as $line) {
      if($line === '') {
        $step = 'moves';
        continue;
      }  
      
      switch ($step) {
        case 'stacks':
          
          for($i=0;$i<=strlen($line);$i+=4) {
            $stack = (int) $i/4 + 1;

            if(!array_key_exists($stack, $this->stacks)) {
              $this->stacks[$stack] = [];
            }
            
            $crate = substr($line, $i+1, 1);
            if($crate === ' ' || preg_match('/\d/', $crate)) {
              continue;
            }
            
            array_unshift($this->stacks[$stack], $crate);
          }
          
          break;
        case 'moves':
          preg_match('/^move (\d+) from (\d+) to (\d+)$/', $line, $matches);

          $this->moves[] = [
            $matches[2],//from
            $matches[3],//to
            $matches[1],//times
          ];
          
          break;
      }
    }
  }
  
  private function move9000($from, $to, $times = 1) {
    while($times > 0) {
      $times --;
      
      $crate = array_pop($this->stacks[$from]);
      $this->stacks[$to][] = $crate;
    }
  }

  private function move9001($from, $to, $count = 1) {
    $crates = [];
    
    while($count > 0) {
      $count --;

      array_unshift($crates, array_pop($this->stacks[$from]));
    }

    //var_dump($crates);
    $this->stacks[$to] = array_merge($this->stacks[$to], $crates);
    //$this->stacks[$to] = $this->stacks[$to] + $crates;
  }
  
  public function part1(): string {
    $this->init();

    foreach($this->moves as $move) {
      $this->move9000($move[0], $move[1], $move[2]);
    }

    $result = '';
    foreach($this->stacks as $stack) {
      $result .= end($stack);
    }

    return $result;
  }

  public function part2(): string {
    $this->init();
    
    foreach($this->moves as $move) {
      $this->move9001($move[0], $move[1], $move[2]);
    }

    $result = '';
    foreach($this->stacks as $stack) {
      $result .= end($stack);
    }

    return $result;
  }
}