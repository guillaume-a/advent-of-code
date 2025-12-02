<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day02 extends ChallengeBase
{
    public function partOne(): string
    {
        $total = 0;

        foreach ($this->lines as $line) {
            list($l, $w, $h) = explode('x', $line);
            $l = (int) $l;
            $w = (int) $w;
            $h = (int) $h;

            $total += 2 * $l * $w + 2 * $w * $h + 2 * $h * $l;
            $total += min($l * $w, $w * $h, $h * $l);
        }

        return (string) $total;
    }

    public function partTwo(): string
    {
        $total = 0;

        foreach ($this->lines as $line) {
            $sides = explode('x', $line);
            sort($sides);

            $side1 = (int) array_shift($sides);
            $side2 = (int) array_shift($sides);
            $side3 = (int) array_shift($sides);

            $total += 2 * $side1 + 2 * $side2;
            $total += $side1 * $side2 * $side3;
        }

        return (string) $total;
    }
}
