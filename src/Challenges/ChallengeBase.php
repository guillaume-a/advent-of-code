<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges;

abstract class ChallengeBase implements ChallengeInterface
{
    /** @var array<string> */
    protected array $lines;

    /**
     * @param array<string> $lines
     */
    public function __construct(array $lines)
    {
        $this->lines = $lines;
    }
}
