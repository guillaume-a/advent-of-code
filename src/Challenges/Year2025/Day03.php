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
        $sum = 0;

        foreach ($this->lines as $bank) {
            echo $bank.\PHP_EOL;

            $strings = str_split($bank);

            $batteries = array_map(fn ($b) => (int) $b, $strings);

            $remaining = 12;
            $joltage = 0;
            $startIndex = 0;

            while ($remaining > 0) {
                // echo '$remaining: '.$remaining.' - '.PHP_EOL;
                $biggest = 0;
                $remaining--;

                // echo 'searching biggest in ' . substr($bank, $startIndex, count($batteries) - $remaining) . PHP_EOL;

                for ($i = $startIndex; $i < \count($batteries) - $remaining; ++$i) {
                    if ($batteries[$i] > $biggest) {
                        $biggest = $batteries[$i];
                        $startIndex = $i + 1;
                    }
                }

                // echo 'found '.$biggest.' @ '.$startIndex . ' - ' .$joltage.\PHP_EOL;

                $joltage += $biggest * 10 ** $remaining;
            }

            $sum += $joltage;
        }

        return (string) $sum;
    }
}
