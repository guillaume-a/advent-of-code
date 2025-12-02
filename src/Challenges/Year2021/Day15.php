<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day15 extends ChallengeBase
{
    private array $grid;
    private array $cache = [];

    private int $h = 0;
    private int $w = 0;

    private function buildGrid()
    {
        $this->grid = [];

        foreach ($this->lines as $y => $line) {
            $this->grid[$y] = str_split($line);
        }

        $this->h = \count($this->grid);
        $this->w = \count($this->grid[0]);
    }

    private function calcWeight($x, $y)
    {
        if (isset($this->cache[$x.'-'.$y])) {
            return $this->cache[$x.'-'.$y];
        }

        if ($x < 0 || $x >= $this->w || $y < 0 || $y >= $this->h) {
            return \PHP_INT_MAX;
        }

        if ($x == $this->w - 1 && $y == $this->h - 1) {
            $this->cache[$x.'-'.$y] = $this->grid[$y][$x];
        } else {
            $this->cache[$x.'-'.$y] = $this->grid[$y][$x] +
              min(
                  $this->calcWeight($x + 1, $y),
                  $this->calcWeight($x, $y + 1)
              );
        }

        return $this->cache[$x.'-'.$y];
    }

    public function partOne(): string
    {
        $this->buildGrid();

        $result = $this->calcWeight(0, 0) - $this->grid[0][0];

        for ($y = 0; $y < $this->h; ++$y) {
            for ($x = 0; $x < $this->w; ++$x) {
                echo $this->grid[$y][$x].' ('.str_pad($this->cache[$x.'-'.$y], 3, ' ', \STR_PAD_LEFT).') ';
            }
            echo \PHP_EOL;
        }

        return $result;
    }

    public function partTwo(): string
    {
        return 0;
    }
}
