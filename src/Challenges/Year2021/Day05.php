<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day05 extends ChallengeBase {

  private $grid = [];

  public function partOne(): string {

    $overlap = 0;

    $max_x = 0;
    $max_y = 0;

    foreach($this->lines as $coords) {
      list($start, $end) = explode(' -> ', $coords);
      list($x1, $y1) = explode(',', $start);
      list($x2, $y2) = explode(',', $end);

      // not vertical nor horizontal
      if($x1 != $x2 && $y1 != $y2) {
        continue;
      }

      // from low to high
      if($x2 < $x1) {
        $tmp = $x1;
        $x1 = $x2;
        $x2 = $tmp;
      }

      if($y2 < $y1) {
        $tmp = $y1;
        $y1 = $y2;
        $y2 = $tmp;
      }

      if($x2 > $max_x) {
        $max_x = $x2;
      }

      if($y2 > $max_y) {
        $max_y = $y2;
      }

      for($y = $y1; $y <= $y2; $y++) {
        for($x = $x1; $x <= $x2; $x++) {
          // create grid
          if(!array_key_exists($y, $this->grid)) {
            $this->grid[$y] = [];
          }
          if(!array_key_exists($x, $this->grid[$y])) {
            $this->grid[$y][$x] = 0;
          }

          //
          $this->grid[$y][$x]++;

          if($this->grid[$y][$x] == 2) {
            $overlap++;
          }
        }
      }
    }

    //draw($grid, $max_x, $max_y);

    return $overlap;
  }

  public function partTwo(): string {

    $overlap = 0;

    $max_x = 0;
    $max_y = 0;

    foreach($this->lines as $coords) {
      // For debug inputs, line starting with # will be ignored
      if(substr($coords, 0, 1) === '#') {
        continue;
      }

      list($start, $end) = explode(' -> ', $coords);
      list($x1, $y1) = explode(',', $start);
      list($x2, $y2) = explode(',', $end);

      // For debug draw
      $max_x = max($max_x, $x1, $x2);
      $max_y = max($max_y, $y1, $y2);

      // Direction
      if($x1 == $x2) {
        $overlap += $this->drawVertical($x1, min($y1, $y2), max($y1, $y2));
      }
      elseif($y1 == $y2) {
        $overlap += $this->drawHorizontal($y1, min($x1, $x2), max($x1, $x2));
      }
      else {
        $overlap += $this->drawDiagonal($x1, $y1, $x2, $y2);
      }
    }

    //draw($grid, $max_x, $max_y);

    return $overlap;
  }

  private function draw($w, $h) {
    for($y=0;$y<=$h;$y++) {
      for($x=0;$x<=$w;$x++) {
        if(!isset($this->grid[$y]) || !isset($this->grid[$y][$x])) {
          echo '.';
        } else {
          echo $this->grid[$y][$x];
        }
      }

      echo PHP_EOL;
    }
    echo PHP_EOL;
  }

  private function drawVertical($x, $y1, $y2) {
    $overlap = 0;
    for($y = $y1; $y <= $y2; $y++) {

      if(!array_key_exists($y, $this->grid)) {
        $this->grid[$y] = [];
      }
      if(!array_key_exists($x, $this->grid[$y])) {
        $this->grid[$y][$x] = 0;
      }

      $this->grid[$y][$x]++;

      if($this->grid[$y][$x] == 2) {
        $overlap++;
      }

    }

    return $overlap;

  }

  private function drawHorizontal($y, $x1, $x2) {

    $overlap = 0;
    for($x = $x1; $x <= $x2; $x++) {

      if(!array_key_exists($y, $this->grid)) {
        $this->grid[$y] = [];
      }
      if(!array_key_exists($x, $this->grid[$y])) {
        $this->grid[$y][$x] = 0;
      }

      $this->grid[$y][$x]++;

      if($this->grid[$y][$x] == 2) {
        $overlap++;
      }
    }

    return $overlap;

  }

  private function drawDiagonal($x1, $y1, $x2, $y2) {
    $overlap = 0;

    $draw = true;
    $step_y = ($y1 < $y2) ? 1 : -1;
    $step_x = ($x1 < $x2) ? 1 : -1;

    while($draw) {
      if(!array_key_exists($y1, $this->grid)) {
        $this->grid[$y1] = [];
      }
      if(!array_key_exists($x1, $this->grid[$y1])) {
        $this->grid[$y1][$x1] = 0;
      }

      $this->grid[$y1][$x1]++;

      if($this->grid[$y1][$x1] == 2) {
        $overlap++;
      }

      if($y1 == $y2) {
        $draw = false;
      }

      $y1 += $step_y;
      $x1 += $step_x;
    }

    return $overlap;

  }
}