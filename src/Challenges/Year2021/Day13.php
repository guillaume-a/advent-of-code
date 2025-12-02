<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day13 extends ChallengeBase {
  
  private $charWidth = 5;
  private $paper = [];
  private $w = 0;
  private $h = 0;
  private $instructions = [];
  
  private $alphabet = [
    '#..#.#..#.####.#..#.#..#.#..#.' => 'H', 
    '.##..#..#.#....#.##.#..#..###.' => 'G',
    '.##..#..#.#..#.####.#..#.#..#.' => 'A',
    '..##....#....#....#.#..#..##..' => 'J',
    '###..#..#.###..#..#.#..#.###..' => 'B',
    '.##..#..#.#....#....#..#..##..' => 'C',
    '####.#....###..#....#....####.' => 'E',
  ];

  
  private function print() {
    for($y = 0; $y <= $this->h ;$y++) {
      for($x = 0; $x <= $this->w ;$x++) {
        if(isset($this->paper[$y][$x]) && $this->paper[$y][$x]==1) echo '#';
        else echo '.';
      }
      
      echo PHP_EOL;
    }

    echo PHP_EOL . PHP_EOL;
  }
  
  private function getCharAt($position) {
    $char = '';
    for($y = 0; $y <= $this->h ;$y++) {
      for($x = 0; $x < $this->charWidth ;$x++) {
        if(isset($this->paper[$y][$position * $this->charWidth + $x]) && $this->paper[$y][$position * $this->charWidth + $x]==1) $char .= '#';
        else $char .= '.';
      }
      
      //$char .= PHP_EOL;
    }

    return $char;
  }
  
  private function count() {
    $score = 0;
    for($y = 0; $y <= $this->h ;$y++) {
      for($x = 0; $x <= $this->w ;$x++) {
        $score += (isset($this->paper[$y]) && isset($this->paper[$y][$x]) && $this->paper[$y][$x]==1) ? $this->paper[$y][$x] : 0;
      }
    }
    
    return $score;
  }
  
  private function makePaper() {
    foreach($this->lines as $i => $line) {
      if($line === '') {
        return $i;
      }
      
      [$x, $y] = explode(',', $line);
      
      $this->w = max($this->w, $x);
      $this->h = max($this->h, $y);

      if(!array_key_exists($y, $this->paper)) {
        $this->paper[$y] = [];
      }

      $this->paper[$y][$x] = 1;
    }
  }
  
  private function fold($instruction) {
    if(preg_match('/x=(.*)/', $instruction, $m)) {
      $this->foldX($m[1]);
    }elseif(preg_match('/y=(.*)/', $instruction, $m)) {
      $this->foldY($m[1]);
    }
  }
  
  private function foldX($axe) {
    echo 'foldX : ' . $axe . ' - ' . $this->w . PHP_EOL;

    $fold = [];

    for($y = 0; $y <= $this->h ;$y++) {
      
      if(!isset($this->paper[$y])) continue;
      $fold[$y] = [];
      
      for($x = 0; $x < $axe ;$x++) {

        $left = isset($this->paper[$y][$x]);
        $right = isset($this->paper[$y][$this->w - $x]);
        
        //echo $y . ' - Fold ' . $x . '('.$left.')' . ' and ' . ($this->w - $x) . '('.$right.') => ' . ($left || $right) . PHP_EOL;

        if($left || $right) $fold[$y][$x] = 1;
      }
    }

    $this->w = $axe - 1;

    $this->paper = $fold;
  }
  
  private function foldY($axe) {
    echo 'foldY : ' . $axe . ' - ' . $this->h . PHP_EOL;
    
    $fold = [];
    
    for($y = 0; $y < $axe ;$y++) {
      //echo $y . ' - ' . ($this->h - $y) . PHP_EOL;
      
      $line1 = $this->paper[$y] ?? [];
      $line2 = $this->paper[$this->h - $y] ?? [];
      
      $fold[$y] = $line1 + $line2;
    }
    
    $this->h = $axe - 1;

    $this->paper = $fold;
  }
  
  private function prepareInstructions($startLine) {
    $this->instructions = $this->lines;
    array_splice($this->instructions, 0, $startLine);
  }
  
  public function partOne(): string {
    $endOfPaper = $this->makePaper();
    $this->print();
    
    $this->prepareInstructions($endOfPaper + 1);
    
    
    $this->fold(array_shift($this->instructions));
    $this->print();

    return $this->count();
  }

  public function partTwo(): string {
    $endOfPaper = $this->makePaper();
    //$this->print();

    $this->prepareInstructions($endOfPaper + 1);
    
    foreach($this->instructions as $instruction) {
      $this->fold($instruction);
      
    }

    $this->print();
    
    $pass = '';
    for ($i=0;$i<8;$i++) {
      $pass .= $this->alphabet[$this->getCharAt($i)];  
    }
    
    
    return $pass;
  }

}