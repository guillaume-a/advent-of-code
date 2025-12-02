<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day01 extends ChallengeBase
{
    public function partOne(): string
    {
        $greatest = 0;
        $current = 0;

        foreach ($this->lines as $line) {
            if ('' === $line) {
                if ($current > $greatest) {
                    $greatest = $current;
                }
                $current = 0;
            }

            $current += (int) $line;
        }

        return (string) max($current, $greatest);
    }

    public function partTwo(): string
    {
        $list = [];
        $current = 0;

        foreach ($this->lines as $line) {
            if ('' === $line) {
                $list[] = $current;
                $current = 0;
            }

            $current += (int) $line;
        }

        $list[] = $current;
        rsort($list);
        $top3 = array_splice($list, 0, 3);

        return (string) array_sum($top3);
    }
}
