<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day03 extends ChallengeBase {

  public function partOne(): string {

    $first = true;
    $sums = [];
    $half = count($this->lines) * .5;

    $epsylon = '';
    $gamma = '';

    foreach($this->lines as $line) {
      $bits = str_split($line);
      $size = count($bits);

      //Avoid undefined indexes
      if($first) {
        $sums = array_fill(0, $size, 0);
        $first = false;
      }

      foreach($bits as $position => $value) {
        $sums[$position] += (int) $value;
      }
    }

    foreach($sums as $value) {
      $most_common = ($value > $half) ? '1' : '0';
      $least_common = ($value > $half) ? '0' : '1';

      $epsylon .= $most_common;
      $gamma .= $least_common;
    }

    return bindec($epsylon) * bindec($gamma);
  }

  public function partTwo(): string {
    $oxygen = $this->calculate_oxygen_rating($this->lines);
    $co2 = $this->calculate_co2_rating($this->lines);

    return bindec($oxygen) * bindec($co2);
  }


  private function get_most_common_bit($lines, $position): string {
    $half = count($lines) * .5;
    $sum = 0;

    foreach($lines as $line) {
      $bits = str_split($line);
      $sum += $bits[$position];
    }

    return $sum >= $half ? '1' : '0';
  }

  private function invert($bit): string {
    return $bit === '1' ? '0' : '1';
  }

  private function calculate_oxygen_rating($lines) {

    $size = strlen($lines[0]);

    $mask = '';

    for($i=0;$i<$size;$i++) {
      $mask .= $this->get_most_common_bit($lines, $i);
      $keep = [];

      foreach($lines as $line) {
        if(preg_match('/^' . $mask . '/', $line)) {
          $keep[] = $line;
        }
      }

      if(count($keep) === 1) {
        return reset($keep);
      }

      $lines = $keep;
    }

    return 0;
  }

  private function calculate_co2_rating($lines) {

    $size = strlen($lines[0]);

    $mask = '';

    for($i=0;$i<$size;$i++) {
      $mask .= $this->invert($this->get_most_common_bit($lines, $i));
      $keep = [];

      foreach($lines as $line) {
        if(preg_match('/^' . $mask . '/', $line)) {
          $keep[] = $line;
        }
      }

      if(count($keep) === 1) {
        return reset($keep);
      }

      $lines = $keep;
    }

    return 0;
  }
}