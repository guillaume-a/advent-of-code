<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day03 extends ChallengeBase
{
    public function partOne(): string
    {
        $sum = 0;

        foreach ($this->lines as $bank) {
            $strings = str_split($bank);

            $batteries = array_map(fn ($b) => (int) $b, $strings);

            $first = 0;
            $second = 0;

            $batteriesCount = \count($batteries);

            foreach ($batteries as $i => $battery) {
                if ($battery > $first && $i < $batteriesCount - 1) {
                    $first = $battery;
                    $second = 0;
                    continue;
                }

                if ($battery > $second) {
                    $second = $battery;
                }
            }

            echo $first.' - '.$second.\PHP_EOL;

            $sum += $first * 10;
            $sum += $second;
        }

        return (string) $sum;
    }

    public function partTwo(): string
    {
        // TODO: Implement partTwo
        return '';
    }
}
