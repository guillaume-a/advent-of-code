<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day05 extends ChallengeBase
{
    /** @var array<int, array{int, int}> */
    private array $ranges = [];
    /** @var array<int, int> */
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
        $this->splitData();

        $mergedRanges = [];
        $count = 0;

        foreach ($this->ranges as $index => &$range) {
            // $mergedRanges[] = $index;
            if (\array_key_exists($index, $mergedRanges)) {
                // echo $index.' skip merged'.PHP_EOL;
                continue;
            }

            foreach ($this->ranges as $otherIndex => $otherRange) {
                if ($index === $otherIndex) {
                    // echo 'skip myself'.PHP_EOL;
                    continue;
                }

                if (\array_key_exists($otherIndex, $mergedRanges)) {
                    // echo $index.' skip merged'.PHP_EOL;
                    continue;
                }

                // if ($index > $otherIndex) {
                // echo 'skip myself'.PHP_EOL;
                // continue;
                // }

                // L'autre range est hors de notre range, out of bounds, on passe a l'autre range suivant
                if ($range[1] < $otherRange[0] || $range[0] > $otherRange[1]) {
                    // echo 'skip oob'.PHP_EOL;
                    continue;
                }

                // Saved other as merged
                $mergedRanges[] = $otherIndex;

                // echo 'merge'.PHP_EOL;
                echo 'merge '.$index.' with '.$otherIndex.\PHP_EOL;
                echo $range[0].' - '.$range[1].\PHP_EOL;
                echo $otherRange[0].' - '.$otherRange[1].\PHP_EOL;

                if ($otherRange[0] < $range[0]) {
                    $range[0] = $otherRange[0];
                }

                if ($otherRange[1] > $range[1]) {
                    $range[1] = $otherRange[1];
                }

                echo $range[0].' - '.$range[1].\PHP_EOL.\PHP_EOL;
            }

            // Saved self as merged
            // $mergedRanges[] = $index;
        }

        foreach ($mergedRanges as $index) {
            unset($this->ranges[$index]);
        }

        foreach ($this->ranges as $mergedRange) {
            $count += ($mergedRange[1] - $mergedRange[0] + 1);
        }

        echo \count($this->ranges).\PHP_EOL;
        // var_dump($this->ranges);

        return (string) $count;
    }

    private function splitData(): void
    {
        $ids = false;
        foreach ($this->lines as $line) {
            if ('' === $line) {
                $ids = true;
                continue;
            }
            if (!$ids) {
                $parts = array_map(fn ($v) => (int) $v, explode('-', $line));
                $this->ranges[] = [$parts[0], $parts[1]];
                continue;
            }

            $this->ids[] = (int) $line;
        }
    }
}
