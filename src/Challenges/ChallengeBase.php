<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges;

abstract class ChallengeBase implements ChallengeInterface
{
    protected array $lines;

    public function __construct($lines)
    {
        $this->lines = $lines;
    }
}
