<?php

namespace Joky\AdventOfCode\Challenges\Year_2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_04 extends ChallengeBase {

  public function part1(): string {

    //store numbers out
    $numbers = explode(',', array_shift($this->lines));

    //build grids
    $grid = null;
    $grids = [];

    foreach($this->lines as $line) {
      if($line === '') {
        $grid = new Grid();
        $grids[] = $grid;
        continue;
      }

      $grid->addLine($line);
    }

    foreach($numbers as $number) {

      echo 'Playing number : ' . $number . PHP_EOL;

      foreach($grids as $grid) {

        $grid->scoreNumber($number);

        echo $grid;

        if($grid->isWin()) {
          return $number * $grid->getScore();
        }
      }
    }
  }

  public function part2(): string {

    //store numbers out
    $numbers = explode(',', array_shift($this->lines));

    //build grids
    $grid = null;
    $grids = [];

    foreach($this->lines as $line) {
      if($line === '') {
        $grid = new Grid();
        $grids[] = $grid;
        continue;
      }

      $grid->addLine($line);
    }

    foreach($numbers as $number) {

      echo 'Playing number : ' . $number . PHP_EOL;

      $loosing_grid = [];

      foreach($grids as $grid) {

        $grid->scoreNumber($number);

        echo $grid;

        //last grid
        if(count($grids) === 1) {
          if($grid->isWin()) {
            return $number * $grid->getScore();
          }
        } else {
          if(!$grid->isWin()) {
            $loosing_grid[] = $grid;
          }
        }

      }

      $grids = $loosing_grid;
    }
  }
}

class Cell {
  private $value;
  private $scored = false;

  public function __construct($value) {
    $this->value = $value;
  }

  /**
   * @return mixed
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @return bool
   */
  public function isScored() {
    return $this->scored;
  }

  public function setScored() {
    $this->scored = true;
  }

  public function __toString() {
    $number = $this->scored ? '  ' : str_pad($this->getValue(), 2, " ", STR_PAD_LEFT);
    return '[' . $number . '] ';
  }

}

class Grid {

  private $lines = [];
  public $numbers = [];

  public function addLine($values) {
    $line = [];

    $values = str_replace('  ', ' ', trim($values));
    foreach(explode(' ', $values) as $value) {
      //store number positions
      $this->numbers[$value] = [count($line), count($this->lines)];

      $line[] = new Cell($value);
    }

    $this->lines[] = $line;
  }

  public function scoreNumber($number) {
    if(!array_key_exists($number, $this->numbers)) {
      return;
    }

    $position = $this->numbers[$number];

    $cell = $this->lines[$position[1]][$position[0]];
    $cell->setScored();
  }

  public function getScore() {
    $score = 0;

    foreach($this->lines as $line) {
      /** @var Cell $cell */
      foreach ($line as $cell) {
        if (!$cell->isScored()) {
          $score += $cell->getValue();
        }
      }
    }

    return $score;
  }

  public function isWin() {

    $bingo_1_score = 0;
    $bingo_2_score = 0;
    $col_score = [0,0,0,0,0];

    foreach($this->lines as $y => $line) {
      $line_score = 0;

      /** @var Cell $cell */
      foreach ($line as $x => $cell) {
        if($cell->isScored()) {
          $line_score ++;
          $col_score[$x] ++;
        }

        if($x === $y && $cell->isScored()) {
          $bingo_1_score ++;
        }

        if($x === 4 - $y && $cell->isScored()) {
          $bingo_2_score ++;
        }
      }

      if($line_score === 5) return true;
      //      if($bingo_1_score === 5) return true;
      //      if($bingo_2_score === 5) return true;
      if(in_array(5, $col_score)) return true;
    }

    return false;


  }

  public function __toString() {

    $result = '';
    foreach($this->lines as $line) {
      $result .= implode('', $line);
      $result .= PHP_EOL;
    }

    $result .= PHP_EOL;

    return $result;
  }

}