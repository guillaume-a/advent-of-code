<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day09 extends ChallengeBase
{
    private $bigLine;
    private $width;
    private $size;
    private $anwser;

    private function prepare()
    {
        $this->width = \strlen($this->lines[0]);
        $this->bigLine = implode('', $this->lines);
        $this->size = \strlen($this->bigLine);
        $this->anwser = 0;
    }

    public function partOne(): string
    {
        $this->prepare();

        foreach (str_split($this->bigLine) as $position => $depth) {
            $left = ($position >= 1) ? (int) substr($this->bigLine, $position - 1, 1) : 10;
            $right = ($position < $this->size - 1) ? (int) substr($this->bigLine, $position + 1, 1) : 10;
            $up = ($position >= $this->width) ? (int) substr($this->bigLine, $position - $this->width, 1) : 10;
            $down = ($position < $this->size - $this->width) ? (int) substr($this->bigLine, $position + $this->width, 1) : 10;

            if (
                $depth < $left
                && $depth < $right
                && $depth < $up
                && $depth < $down
            ) {
                $this->anwser += (int) $depth + 1;
            }
        }

        return $this->anwser;
    }

    public function partTwo(): string
    {
        $this->prepare();

        $explored = [];
        $basins = [];
        $position = 0;

        do {
            if (!\in_array($position, $explored)) {
                $basin = $this->exploreBasin($position);

                $basins[] = \count($basin);
                $explored = array_merge($explored, $basin);

                sort($basin);
                sort($explored);
            }
        } while ($position++ < $this->size - 1);

        sort($basins);

        return array_pop($basins) * array_pop($basins) * array_pop($basins);
    }

    private function exploreBasin($position, &$basin = []): array
    {
        // Allready explored
        if (\in_array($position, $basin)) {
            return [];
        }

        $depth = (int) substr($this->bigLine, $position, 1);

        // Find a wall, stop here
        if (9 === $depth) {
            return [];
        }

        // Add current position to basin
        $basin[] = $position;

        // Explore each directions
        // Left
        if ($position % $this->width > 0) {
            $basin += $this->exploreBasin($position - 1, $basin);
        }

        // Right
        if ($position % $this->width < $this->width - 1) {
            $basin += $this->exploreBasin($position + 1, $basin);
        }

        // Up
        if ($position >= $this->width) {
            $basin += $this->exploreBasin($position - $this->width, $basin);
        }

        // Down
        if ($position < $this->size - $this->width) {
            $basin += $this->exploreBasin($position + $this->width, $basin);
        }

        return $basin;
    }
}
