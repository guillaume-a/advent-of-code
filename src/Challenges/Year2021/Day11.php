<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day11 extends ChallengeBase {

  private array $grid;
  private array $dayFlashes = [];

  protected function increment($x, $y) {
    if(in_array($x.'-'.$y, $this->dayFlashes)) 
      return;
    
    $this->grid[$y][$x]++;

    if($this->grid[$y][$x] == 10) {
      $this->grid[$y][$x] = 0;
      $this->flash($x, $y);
    }
  }
  
  protected function flash($x, $y) {
    $this->dayFlashes[] = $x.'-'.$y;
    
    for($dy=-1;$dy<=1;$dy++) {
      for($dx=-1;$dx<=1;$dx++) {
        if($dx === 0 && $dy === 0) continue;
        if(!isset($this->grid[$y+$dy])) continue;
        if(!isset($this->grid[$y+$dy][$x+$dx])) continue;

        $this->increment($x+$dx, $y+$dy);
      }
    }
  }
  
  protected function draw() {
    
    foreach ($this->grid as $line) {
      echo implode('', $line) . PHP_EOL;
    }
    
    echo PHP_EOL;
  }
  
  public function partOne(): string {
    $score = 0;
    $steps = 100;

    //init grid
    $this->grid = [];
    foreach ($this->lines as $y => $line) {
      $this->grid[$y] = str_split($line);
    }

    $this->draw();

    // Run steps
    while($steps > 0) {
      $this->dayFlashes = [];
      
      // Increment everyone
      foreach ($this->grid as $y => $line) {
        foreach ($line as $x => $energy) {
          $this->increment($x, $y);
        }
      }
      
      $this->draw();
      
      $score += count($this->dayFlashes);

      $steps--;
    }

    return $score;
  }

  
  public function partTwo(): string {
    $step = 0;

    //init grid
    $this->grid = [];
    foreach ($this->lines as $y => $line) {
      $this->grid[$y] = str_split($line);
    }

    $size = count($this->lines) * count($this->grid[0]);

    $this->draw();

    // Run steps
    while(true) {
      $this->dayFlashes = [];

      // Increment everyone
      foreach ($this->grid as $y => $line) {
        foreach ($line as $x => $energy) {
          $this->increment($x, $y);
        }
      }

      $this->draw();

      $step ++;
      
      if(count($this->dayFlashes) == $size) {
        return $step;
      }
    }

  }

}