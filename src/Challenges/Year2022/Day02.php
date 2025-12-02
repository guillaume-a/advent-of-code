<?php

namespace Joky\AdventOfCode\Challenges\Year2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day02 extends ChallengeBase {

  const RESULT_WIN = 6;
  const RESULT_DRAW = 3;
  const RESULT_LOSE = 0;
  
  private $points = [
    'Rock' => 1,
    'Paper' => 2,
    'Scissors' => 3,
  ];
  
  private $win = [
    'Rock' => 'Scissors',
    'Scissors' => 'Paper',
    'Paper' => 'Rock',
  ];

  private $loose = [
    'Rock' => 'Paper',
    'Scissors' => 'Rock',
    'Paper' => 'Scissors',
  ];

  public function partOne(): string {
    $shapes = [
      'A' => 'Rock',
      'B' => 'Paper',
      'C' => 'Scissors',

      'X' => 'Rock',
      'Y' => 'Paper',
      'Z' => 'Scissors',      
    ];
         
    $score = 0;
    
    foreach ($this->lines as $game) {
      [$cpu, $me] = explode(' ',$game);
      
      $shapeCpu = $shapes[$cpu]; 
      $shapeMe = $shapes[$me]; 
      
      $score += $this->points[$shapeMe];
      
      if($shapeCpu === $shapeMe) {
        $score += self::RESULT_DRAW;
        continue;
      }
      
      if($this->win[$shapeMe] === $shapeCpu) {
        $score += self::RESULT_WIN;
        continue;
      }

      $score += self::RESULT_LOSE;
    }
    
    return (string) $score;
  }

  public function partTwo(): string {
    $shapes = [
      'A' => 'Rock',
      'B' => 'Paper',
      'C' => 'Scissors',
    ];
    
    $needed = [
      'X' => 'Lose',
      'Y' => 'Draw',
      'Z' => 'Win',
    ];

    $score = 0;

    foreach ($this->lines as $game) {
      [$cpu, $need] = explode(' ',$game);

      $shapeCpu = $shapes[$cpu];
      
      if($need === 'X') {
        $shapeMe = $this->win[$shapeCpu];
        $score += self::RESULT_LOSE;
      }
      
      if($need === 'Y') {
        $shapeMe = $shapeCpu;
        $score += self::RESULT_DRAW;
      }
      
      if($need === 'Z') {
        $shapeMe = $this->loose[$shapeCpu];
        $score += self::RESULT_WIN;
      }
      
      $score += $this->points[$shapeMe];
    }

    return (string) $score;
  }
}