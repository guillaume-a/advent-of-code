<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day04 extends ChallengeBase
{
    public function partOne(): string
    {
        $count = 0;

        $grid = [];

        foreach ($this->lines as $y => $line) {
            $row = str_split($line);

            foreach ($row as $x => $cell) {
                $grid[$y][$x] = $cell;
            }
        }

        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                if ('.' === $cell) {
                    continue;
                }

                $neighbours = 0;

                for ($oy = $y - 1; $oy <= $y + 1; ++$oy) {
                    for ($ox = $x - 1; $ox <= $x + 1; ++$ox) {
                        if ($ox === $x && $oy === $y) {
                            continue;
                        }

                        if (!isset($grid[$oy][$ox])) {
                            continue;
                        }

                        if ('@' === $grid[$oy][$ox]) {
                            ++$neighbours;
                        }
                    }
                }

                if ($neighbours < 4) {
                    ++$count;
                }
            }
        }

        return (string) $count;
    }

    public function partTwo(): string
    {
        $count = 0;

        $grid = [];

        // Initial grid creation
        foreach ($this->lines as $y => $line) {
            $row = str_split($line);

            foreach ($row as $x => $cell) {
                $grid[$y][$x] = $cell;
            }
        }

        do {
            $removed = [];

            foreach ($grid as $y => $row) {
                foreach ($row as $x => $cell) {
                    if ('.' === $cell) {
                        continue;
                    }

                    $neighbours = 0;

                    for ($oy = $y - 1; $oy <= $y + 1; ++$oy) {
                        for ($ox = $x - 1; $ox <= $x + 1; ++$ox) {
                            if ($ox === $x && $oy === $y) {
                                continue;
                            }

                            if (!isset($grid[$oy][$ox])) {
                                continue;
                            }

                            if ('@' === $grid[$oy][$ox]) {
                                ++$neighbours;
                            }
                        }
                    }

                    if ($neighbours < 4) {
                        $removed[] = [$y, $x];
                    }
                }
            }

            $count += \count($removed);

            // Update grid
            foreach ($removed as $cell) {
                $grid[$cell[0]][$cell[1]] = '.';
            }
        } while (\count($removed) > 0);

        return (string) $count;
    }
}
