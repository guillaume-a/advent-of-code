<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

/**
 * 0:      1:      2:      3:      4:
 * aaaa    ....    aaaa    aaaa    ....
 * b    c  .    c  .    c  .    c  b    c
 * b    c  .    c  .    c  .    c  b    c
 * ....    ....    dddd    dddd    dddd
 * e    f  .    f  e    .  .    f  .    f
 * e    f  .    f  e    .  .    f  .    f
 * gggg    ....    gggg    gggg    ....
 *
 * 5:      6:      7:      8:      9:
 * aaaa    aaaa    aaaa    aaaa    aaaa
 * b    .  b    .  .    c  b    c  b    c
 * b    .  b    .  .    c  b    c  b    c
 * dddd    dddd    ....    dddd    dddd
 * .    f  e    f  .    f  e    f  .    f
 * .    f  e    f  .    f  e    f  .    f
 * gggg    gggg    ....    gggg    gggg
 */
class Day08 extends ChallengeBase
{
    public function partOne(): string
    {
        $anwser = 0;

        foreach ($this->lines as $entry) {
            [$in, $out] = explode(' | ', $entry);
            $digits = explode(' ', $out);

            $anwser += \count(array_filter($digits, function ($digit) {
                return \in_array(\strlen($digit), [2, 3, 4, 7]);
            }));
        }

        return $anwser;
    }

    public function partTwo(): string
    {
        $anwser = 0;

        foreach ($this->lines as $entry) {
            [$in, $out] = explode(' | ', $entry);

            // Guess each number
            $inDigits = explode(' ', $in);

            // Easy ones
            $one = $this->findOneByLength($inDigits, 2);
            $four = $this->findOneByLength($inDigits, 4);
            $seven = $this->findOneByLength($inDigits, 3);
            $height = $this->findOneByLength($inDigits, 7);

            // Find Two, Three and Five
            $fiveDigits = $this->findByLength($inDigits, 5);

            foreach ($fiveDigits as $fiveDigit) {
                // var_dump($fiveDigit);

                $tmp = $this->diff($fiveDigit, $one);

                if (3 === \strlen($tmp)) {
                    $three = $fiveDigit;
                } else {
                    $tmp = $this->diff($tmp, $four);

                    if (2 === \strlen($tmp)) {
                        $five = $fiveDigit;
                    } else {
                        $two = $fiveDigit;
                    }
                }
            }

            // Six, Nine and Zero
            $sixDigits = $this->findByLength($inDigits, 6);

            foreach ($sixDigits as $sixDigit) {
                $tmp = $this->diff($sixDigit, $one);

                if (5 === \strlen($tmp)) {
                    $six = $sixDigit;
                } else {
                    $tmp = $this->diff($tmp, $four);

                    if (2 === \strlen($tmp)) {
                        $nine = $sixDigit;
                    } else {
                        $zero = $sixDigit;
                    }
                }
            }

            // Arrange digit in array
            $numbers = [
                $this->sort($zero) => '0',
                $this->sort($one) => '1',
                $this->sort($two) => '2',
                $this->sort($three) => '3',
                $this->sort($four) => '4',
                $this->sort($five) => '5',
                $this->sort($six) => '6',
                $this->sort($seven) => '7',
                $this->sort($height) => '8',
                $this->sort($nine) => '9',
            ];

            // Calculate output
            $outDigits = explode(' ', $out);
            $number = '';

            foreach ($outDigits as $outDigit) {
                $number .= $numbers[$this->sort($outDigit)];
            }

            $anwser += (int) $number;
        }

        return $anwser;
    }

    private function findByLength($digits, $length): array
    {
        return array_values(array_filter($digits, function ($d) use ($length) { return \strlen($d) === $length; }));
    }

    private function findOneByLength($digits, $length): string
    {
        return $this->findByLength($digits, $length)[0];
    }

    private function diff($str1, $str2)
    {
        return implode('', array_diff(str_split($str1), str_split($str2)));
    }

    private function sort($str)
    {
        $a = str_split($str);
        sort($a);

        return implode('', $a);
    }
}
