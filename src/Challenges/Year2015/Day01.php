<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day01 extends ChallengeBase
{
    public function partOne(): string
    {
        $directions = str_split($this->lines[0]);

        $floor = 0;

        foreach ($directions as $direction) {
            $floor += '(' === $direction ? 1 : -1;
        }

        return $floor;
    }

    public function partTwo(): string
    {
        $directions = str_split($this->lines[0]);

        $floor = 0;

        foreach ($directions as $position => $direction) {
            $floor += '(' === $direction ? 1 : -1;

            if (-1 === $floor) {
                return $position + 1;
            }
        }
    }
}
