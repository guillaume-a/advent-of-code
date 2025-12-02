<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day01 extends ChallengeBase
{
    public function partOne(): string
    {
        $password = 0;
        $currentPosition = 50;

        foreach ($this->lines as $line) {
            $direction = substr($line, 0, 1);
            $ticks = (int) substr($line, 1);

            $multiplier = match ($direction) {
                'L' => -1,
                'R' => 1,
                default => 0,
            };

            $currentPosition += $ticks * $multiplier;

            echo $direction.' - '.$ticks.' - '.$currentPosition.\PHP_EOL;

            while ($currentPosition >= 100) {
                $currentPosition -= 100;
            }

            while ($currentPosition < 0) {
                $currentPosition = 100 + $currentPosition;
            }

            if (0 == $currentPosition) {
                ++$password;
            }

            echo $direction.' - '.$ticks.' - '.$currentPosition.\PHP_EOL;
        }

        return (string) $password;
    }

    public function partTwo(): string
    {
        // TODO: Implement partTwo
        return '';
    }
}
