<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day06 extends ChallengeBase
{
    public function partOne(): string
    {
        $daysToCount = 80;

        $line = reset($this->lines);
        echo 'Initial state:  '.$line.\PHP_EOL;
        $initValues = explode(',', $line);

        $fishes = [];

        foreach ($initValues as $value) {
            $fishes[] = new Lanternfish($value);
        }

        $currentDay = 0;

        while ($currentDay < $daysToCount) {
            array_map(function (Lanternfish $fish) {$fish->tick(); }, $fishes);

            ++$currentDay;

            // echo 'After day ' . $currentDay . ':  ' . implode(',', $fishes) . PHP_EOL;

            $fishToReset = array_filter($fishes, function (Lanternfish $fish) {return $fish->reset(); });

            if ($currentDay === $daysToCount) {
                break;
            }

            // var_dump(count($fishAtZero));
            $newFishes = \count($fishToReset);

            for ($i = 0; $i < $newFishes; ++$i) {
                $fishes[] = new Lanternfish(9);
            }
        }

        return \count($fishes);
    }

    public function partTwo(): string
    {
        $daysToCount = 256;

        $fishes = array_fill(0, 9, 0);
        $line = reset($this->lines);
        echo 'Initial state:  '.$line.\PHP_EOL;
        $initValues = explode(',', $line);

        foreach ($initValues as $value) {
            ++$fishes[$value];
        }

        $currentDay = 0;

        while ($currentDay < $daysToCount) {
            $fishToReset = $fishes[0];

            $fishes = [
                $fishes[1],
                $fishes[2],
                $fishes[3],
                $fishes[4],
                $fishes[5],
                $fishes[6],
                $fishes[7],
                $fishes[8],
                0,
            ];

            ++$currentDay;

            $fishes[6] += $fishToReset;
            $fishes[8] += $fishToReset;
        }

        return array_sum($fishes);
    }
}

class Lanternfish implements \Stringable
{
    private $timer;

    public function __construct($timer)
    {
        $this->timer = $timer;
    }

    public function tick()
    {
        --$this->timer;
    }

    public function reset()
    {
        if (0 === $this->timer) {
            $this->timer = 7;

            return true;
        }

        return false;
    }

    public function __toString()
    {
        return (string) $this->timer;
    }
}
