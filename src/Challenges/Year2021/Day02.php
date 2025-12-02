<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day02 extends ChallengeBase
{
    public function partOne(): string
    {
        $x = 0;
        $y = 0;

        foreach ($this->lines as $line) {
            list($command, $force) = explode(' ', $line);

            switch ($command) {
                case 'forward':
                    $x += (int) $force;
                    break;
                case 'down':
                    $y += (int) $force;
                    break;
                case 'up':
                    $y -= (int) $force;
                    break;
            }
        }

        return (string) $x * $y;
    }

    public function partTwo(): string
    {
        $x = 0;
        $y = 0;
        $aim = 0;

        foreach ($this->lines as $line) {
            list($command, $force) = explode(' ', $line);

            switch ($command) {
                case 'forward':
                    $x += (int) $force;
                    $y += $aim * (int) $force;
                    break;
                case 'down':
                    $aim += (int) $force;
                    break;
                case 'up':
                    $aim -= (int) $force;
                    break;
            }
        }

        return (string) $x * $y;
    }
}
