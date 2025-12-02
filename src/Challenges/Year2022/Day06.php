<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day06 extends ChallengeBase
{
    public function partOne(): string
    {
        $line = reset($this->lines);

        for ($i = 0; $i < \strlen($line) - 4; ++$i) {
            $marker = str_split(substr($line, $i, 4));
            $digits = array_unique($marker);
            if (4 === \count($digits)) {
                return (string) ($i + 4);
            }
        }

        return '0';
    }

    public function partTwo(): string
    {
        $line = reset($this->lines);

        for ($i = 0; $i < \strlen($line) - 14; ++$i) {
            $marker = str_split(substr($line, $i, 14));
            $digits = array_unique($marker);
            if (\count($digits) === \count($marker)) {
                return (string) ($i + 14);
            }
        }

        return '0';
    }
}
