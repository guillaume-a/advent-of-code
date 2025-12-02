<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day10 extends ChallengeBase
{
    private array $open = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];

    private array $corruptedPoints = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137,
    ];

    private array $incompletePoints = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4,
    ];

    public function partOne(): string
    {
        $score = 0;

        foreach ($this->lines as $i => $line) {
            $expected = [];
            echo \PHP_EOL.\PHP_EOL.$i.' - '.$line.\PHP_EOL.\PHP_EOL;

            foreach (str_split($line) as $chr) {
                echo $chr.' - '.implode(',', $expected).\PHP_EOL;

                if (\array_key_exists($chr, $this->open)) {
                    // Open chr = wait for close
                    array_unshift($expected, $this->open[$chr]);
                    continue;
                }

                if (!empty($expected) && current($expected) != $chr) {
                    echo '^    CORRUPTED, Expected '.current($expected).', but found '.$chr.' instead.'.\PHP_EOL;
                    $score += $this->corruptedPoints[$chr];
                    break;
                }

                // Close chr = remove wait
                array_shift($expected);
            }
        }

        return (string) $score;
    }

    public function partTwo(): string
    {
        $scores = [];

        foreach ($this->lines as $i => $line) {
            $expected = [];
            echo \PHP_EOL.\PHP_EOL.$i.' - '.$line.\PHP_EOL.\PHP_EOL;

            foreach (str_split($line) as $chr) {
                echo $chr.' - '.implode(',', $expected).\PHP_EOL;

                if (\array_key_exists($chr, $this->open)) {
                    // Open chr = wait for close
                    array_unshift($expected, $this->open[$chr]);
                    continue;
                }

                if (!empty($expected) && current($expected) != $chr) {
                    echo '^    CORRUPTED, Expected '.current($expected).', but found '.$chr.' instead.'.\PHP_EOL;
                    $expected = [];
                    break;
                }

                // Close chr = remove wait
                array_shift($expected);
            }

            if (!empty($expected)) {
                $score = 0;
                foreach ($expected as $chr) {
                    $score *= 5;
                    $score += $this->incompletePoints[$chr];
                }

                $scores[] = $score;

                echo '^    INCOMPLETE'.\PHP_EOL;
                echo implode('', $expected).' - Score : '.$score.\PHP_EOL;
            }
        }

        sort($scores);

        return (string) $scores[(int) floor(\count($scores) / 2)];
    }
}
