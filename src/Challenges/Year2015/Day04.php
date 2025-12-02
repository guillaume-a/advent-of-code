<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2015;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day04 extends ChallengeBase
{
    public function partOne(): string
    {
        $i = 0;
        $private = reset($this->lines);
        do {
            $hash = md5($private.++$i);
        } while (!str_starts_with($hash, '00000'));

        return $i;
    }

    public function partTwo(): string
    {
        $i = 0;
        $private = reset($this->lines);
        do {
            $hash = md5($private.++$i);
        } while (!str_starts_with($hash, '000000'));

        return $i;
    }
}
