<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day02 extends ChallengeBase
{
    public function partOne(): string
    {
        $ranges = explode(',', $this->lines[0]);
        $sum = 0;

        foreach ($ranges as $range) {
            list($firstId, $lastId) = explode('-', $range);

            for ($i = (int) $firstId; $i <= (int) $lastId; ++$i) {
                $len = \strlen((string) $i);
                if (0 !== $len % 2) {
                    continue;
                }

                $firstHalf = substr((string) $i, 0, (int) ($len / 2));
                $secondHalf = substr((string) $i, (int) ($len / 2));

                if ($firstHalf === $secondHalf) {
                    $sum += $i;
                }
            }
        }

        return (string) $sum;
    }

    public function partTwo(): string
    {
        $ranges = explode(',', $this->lines[0]);
        $sum = 0;

        foreach ($ranges as $range) {
            list($firstId, $lastId) = explode('-', $range);

            $invalids = [];

            for ($i = (int) $firstId; $i <= (int) $lastId; ++$i) {
                $len = \strlen((string) $i);
                for ($j = 1; $j < $len; ++$j) {
                    if (0 !== $len % $j) {
                        continue;
                    }

                    $pattern = substr((string) $i, 0, $j);

                    $forged = str_repeat($pattern, (int) ($len / $j));

                    if ((string) $i === $forged) {
                        $invalids[] = $i;
                    }
                }
            }

            $invalids = array_unique($invalids);
            $sum += array_sum($invalids);
        }

        return (string) $sum;
    }
}
