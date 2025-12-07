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
        $grandTotal = 0;
        $lineCount = 0;
        $colCount = 0;

        $rows = [];

        foreach ($this->lines as $line) {
            $row = str_split($line);

            // On garde cette fois la taille de ligne la plus grande.
            $lineSize = \count($row);

            if ($lineSize > $colCount) {
                $colCount = $lineSize;
            }

            ++$lineCount;

            $rows[] = $row;
        }

        // --$lineCount;

        $isOperand = false;
        $strNumbers = '';
        $operand = '';

        while ($colCount > 0) {
            for ($j = 0; $j < $lineCount; ++$j) {
                $chr = $rows[$j][$colCount - 1] ?? '';

                if ('+' === $chr || '*' === $chr) {
                    $isOperand = true;
                    $operand = $chr;
                } elseif (preg_match('/[0-9]/', $chr)) {
                    $strNumbers .= $chr;
                }
            }

            $strNumbers .= ' ';

            if ($isOperand) {
                $strNumbers = trim($strNumbers);
                // echo 'do stuff with : ';
                // echo '['.$strNumbers.']'.\PHP_EOL;

                $littleTotal = '*' === $operand ? 1 : 0;

                $arrayNumbers = explode(' ', $strNumbers);

                foreach ($arrayNumbers as $number) {
                    $littleTotal = match ($operand) {
                        '+' => $littleTotal + (int) $number,
                        '*' => $littleTotal * (int) $number,
                        default => throw new \Exception('Unknown operand: '.$operand),
                    };
                }

                $grandTotal += $littleTotal;
                $strNumbers = '';
                $isOperand = false;
            }

            --$colCount;
        }

        return (string) $grandTotal;
    }
}
