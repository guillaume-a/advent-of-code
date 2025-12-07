<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2025;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day06 extends ChallengeBase
{
    public function partOne(): string
    {
        $grandTotal = 0;
        $lineCount = 0;
        $colCount = 0;

        $rows = [];

        foreach ($this->lines as $line) {
            $line = preg_replace('/\s+/', ' ', trim($line));
            $row = explode(' ', (string) $line);

            $colCount = \count($row);
            ++$lineCount;

            $rows[] = $row;
        }

        // remove operators last line
        --$lineCount;

        for ($i = 0; $i < $colCount; ++$i) {
            $operand = $rows[$lineCount][$i];

            $littleTotal = '*' === $operand ? 1 : 0;

            for ($j = 0; $j < $lineCount; ++$j) {
                $value = (int) $rows[$j][$i];

                $littleTotal = match ($operand) {
                    '+' => $littleTotal + $value,
                    '*' => $littleTotal * $value,
                    default => throw new \Exception('Unknown operand: '.$operand),
                };

                var_dump($littleTotal);
            }

            $grandTotal += $littleTotal;
        }

        return (string) $grandTotal;
    }

    public function partTwo(): string
    {
        // TODO: Implement partTwo
        return '';
    }
}
