<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day17 extends ChallengeBase
{
    private $probe = [];
    private $target = [];

    private function step($velX, $velY)
    {
        // Get currentt position
        $currentProbe = end($this->probe);

        // Apply velocity
        $newProbe = [
            $currentProbe[0] + $velX,
            $currentProbe[1] + $velY,
        ];

        $this->probe[] = $newProbe;

        // Check if target is hit
        if (
            $newProbe[0] >= $this->target[0] && $newProbe[0] <= $this->target[2]
            && $newProbe[1] >= $this->target[1] && $newProbe[1] <= $this->target[3]
        ) {
            // var_dump($newProbe);
            return true;
        }

        // Check if homerun
        if (
            $newProbe[0] > $this->target[2] || $newProbe[1] < $this->target[1]
        ) {
            // var_dump($this->target);
            // var_dump($this->probe);
            return false;
        }

        // Apply drag & continue
        $velX = max(0, $velX - 1);
        --$velY;

        return $this->step($velX, $velY);
    }

    public function partOne(): string
    {
        preg_match('/target area: x=(-?\d*)..(-?\d*), y=(-?\d+)..(-?\d+)/', current($this->lines), $m);

        $this->target = [
            min($m[1], $m[2]),
            min($m[3], $m[4]),
            max($m[1], $m[2]),
            max($m[3], $m[4]),
        ];

        // var_dump($this->target);

        $success = [];
        $answer = 0;

        for ($x = 0; $x <= 100; ++$x) {
            for ($y = 0; $y <= 100; ++$y) {
                // reset probe
                $this->probe = [[0, 0]];

                if ($this->step($x, $y)) {
                    echo 'Launch : '.$x.' | '.$y.\PHP_EOL;

                    $currentProbe = end($this->probe);

                    echo 'Hit at '.$currentProbe[0].' | '.$currentProbe[1].\PHP_EOL;

                    // var_dump($this->probe);
                    $maxY = 0;
                    foreach ($this->probe as $probe) {
                        $maxY = max($maxY, $probe[1]);
                    }

                    echo 'Apex '.$maxY.\PHP_EOL;

                    $success[] = [$x, $y, $maxY];
                    $answer = max($answer, $maxY);
                }
            }
        }

        // var_dump($success);

        return $answer;
    }

    public function partTwo(): string
    {
        preg_match('/target area: x=(-?\d*)..(-?\d*), y=(-?\d+)..(-?\d+)/', current($this->lines), $m);

        $this->target = [
            min($m[1], $m[2]),
            min($m[3], $m[4]),
            max($m[1], $m[2]),
            max($m[3], $m[4]),
        ];

        $success = [];
        for ($x = -500; $x <= 500; ++$x) {
            for ($y = -500; $y <= 500; ++$y) {
                // reset probe
                $this->probe = [[0, 0]];

                if ($this->step($x, $y)) {
                    echo 'Launch : '.$x.' | '.$y.\PHP_EOL;

                    $currentProbe = end($this->probe);

                    echo 'Hit at '.$currentProbe[0].' | '.$currentProbe[1].\PHP_EOL;

                    $success[] = $x.','.$y;
                }
            }
        }

        return \count($success);
    }
}
