<?php

namespace Joky\AdventOfCode\Challenges\Year_2021\Day_08;

use Joky\AdventOfCode\Challenges\ChallengeBase;

/**

0:      1:      2:      3:      4:
 aaaa    ....    aaaa    aaaa    ....
b    c  .    c  .    c  .    c  b    c
b    c  .    c  .    c  .    c  b    c
....    ....    dddd    dddd    dddd
e    f  .    f  e    .  .    f  .    f
e    f  .    f  e    .  .    f  .    f
 gggg    ....    gggg    gggg    ....

5:      6:      7:      8:      9:
 aaaa    aaaa    aaaa    aaaa    aaaa
b    .  b    .  .    c  b    c  b    c
b    .  b    .  .    c  b    c  b    c
 dddd    dddd    ....    dddd    dddd
.    f  e    f  .    f  e    f  .    f
.    f  e    f  .    f  e    f  .    f
gggg    gggg    ....    gggg    gggg

 */
class Challenge extends ChallengeBase {

  public function part1(): string {

    $anwser = 0;

    foreach($this->lines as $entry) {
      list($in, $out) = explode(' | ', $entry);
      $digits = explode(' ', $out);

      $anwser += count(array_filter($digits, function($digit) {
        return in_array(strlen($digit), [2,3,4,7]);
      }));

    }

    return $anwser;
  }

  public function part2(): string {
    return '';
  }
}