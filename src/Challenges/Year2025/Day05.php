<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day05 extends ChallengeBase
{
    private array $ranges = [];
    private array $ids = [];

    public function partOne(): string
    {
        $this->splitData();

        $count = 0;

        foreach ($this->ids as $id) {
            foreach ($this->ranges as $range) {
                if ($id >= $range[0] && $id <= $range[1]) {
                    // id found, skip to next id directly
                    // echo $id . ' found in range ' . implode(',', $range) . PHP_EOL;
                    ++$count;
                    continue 2;
                }
            }

            // echo $id . ' not found' . PHP_EOL;
        }

        return (string) $count;
    }

    public function partTwo(): string
    {
        $count = 0;

        return (string) $count;
    }

    private function splitData()
    {
        $ids = false;
        foreach ($this->lines as $line) {
            if ('' === $line) {
                $ids = true;
                continue;
            }
            if (!$ids) {
                $this->ranges[] = array_map(fn ($v) => (int) $v, explode('-', $line));
                continue;
            }

            $this->ids[] = (int) $line;
        }
    }
}
