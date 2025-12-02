<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day04 extends ChallengeBase
{
    public function partOne(): string
    {
        // store numbers out
        $numbers = explode(',', array_shift($this->lines));

        // build grids
        $grid = null;
        $grids = [];

        foreach ($this->lines as $line) {
            if ('' === $line) {
                $grid = new Grid();
                $grids[] = $grid;
                continue;
            }

            $grid->addLine($line);
        }

        foreach ($numbers as $number) {
            echo 'Playing number : '.$number.\PHP_EOL;

            foreach ($grids as $grid) {
                $grid->scoreNumber($number);

                echo $grid;

                if ($grid->isWin()) {
                    return (string) ($number * $grid->getScore());
                }
            }
        }

        return '0';
    }

    public function partTwo(): string
    {
        // store numbers out
        $numbers = explode(',', array_shift($this->lines));

        // build grids
        $grid = null;
        $grids = [];

        foreach ($this->lines as $line) {
            if ('' === $line) {
                $grid = new Grid();
                $grids[] = $grid;
                continue;
            }

            $grid->addLine($line);
        }

        foreach ($numbers as $number) {
            echo 'Playing number : '.$number.\PHP_EOL;

            $loosing_grid = [];

            foreach ($grids as $grid) {
                $grid->scoreNumber($number);

                echo $grid;

                // last grid
                if (1 === \count($grids)) {
                    if ($grid->isWin()) {
                        return (string) ($number * $grid->getScore());
                    }
                } else {
                    if (!$grid->isWin()) {
                        $loosing_grid[] = $grid;
                    }
                }
            }

            $grids = $loosing_grid;
        }

        return '0';
    }
}

class Cell implements \Stringable
{
    private int $value;
    private bool $scored = false;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isScored(): bool
    {
        return $this->scored;
    }

    public function setScored(): void
    {
        $this->scored = true;
    }

    public function __toString(): string
    {
        $number = $this->scored ? '  ' : str_pad((string) $this->getValue(), 2, ' ', \STR_PAD_LEFT);

        return '['.$number.'] ';
    }
}

class Grid implements \Stringable
{
    /** @var array<array<Cell>> */
    private array $lines = [];
    /** @var array<string, array<int>> */
    public array $numbers = [];

    public function addLine(string $values): void
    {
        $line = [];

        $values = str_replace('  ', ' ', trim($values));
        foreach (explode(' ', $values) as $value) {
            // store number positions
            $this->numbers[$value] = [\count($line), \count($this->lines)];

            $line[] = new Cell((int) $value);
        }

        $this->lines[] = $line;
    }

    public function scoreNumber(string $number): void
    {
        if (!\array_key_exists($number, $this->numbers)) {
            return;
        }

        $position = $this->numbers[$number];

        $cell = $this->lines[$position[1]][$position[0]];
        $cell->setScored();
    }

    public function getScore(): int
    {
        $score = 0;

        foreach ($this->lines as $line) {
            /** @var Cell $cell */
            foreach ($line as $cell) {
                if (!$cell->isScored()) {
                    $score += $cell->getValue();
                }
            }
        }

        return $score;
    }

    public function isWin(): bool
    {
        $bingo_1_score = 0;
        $bingo_2_score = 0;
        $col_score = [0, 0, 0, 0, 0];

        foreach ($this->lines as $y => $line) {
            $line_score = 0;

            /** @var Cell $cell */
            foreach ($line as $x => $cell) {
                if ($cell->isScored()) {
                    ++$line_score;
                    ++$col_score[$x];
                }

                if ($x === $y && $cell->isScored()) {
                    ++$bingo_1_score;
                }

                if ($x === 4 - $y && $cell->isScored()) {
                    ++$bingo_2_score;
                }
            }

            if (5 === $line_score) {
                return true;
            }
            //      if($bingo_1_score === 5) return true;
            //      if($bingo_2_score === 5) return true;
            if (\in_array(5, $col_score)) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        $result = '';
        foreach ($this->lines as $line) {
            $result .= implode('', $line);
            $result .= \PHP_EOL;
        }

        $result .= \PHP_EOL;

        return $result;
    }
}
