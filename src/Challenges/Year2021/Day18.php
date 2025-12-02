<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day18 extends ChallengeBase
{
    private function add($a, $b): string
    {
        return \sprintf('[%s,%s]', $a, $b);
    }

    private function shouldExplode($number): bool|int
    {
        $depth = 0;

        foreach (str_split($number) as $pos => $chr) {
            if ('[' === $chr) {
                ++$depth;
            }
            if (']' === $chr) {
                --$depth;
            }

            if (5 === $depth) {
                return $pos;
            }
        }

        return false;
    }

    private function shouldSplit($number): bool|int
    {
        $was_numeric = false;

        foreach (str_split($number) as $pos => $chr) {
            if (is_numeric($chr)) {
                if ($was_numeric) {
                    return $pos - 1;
                }

                $was_numeric = true;
            } else {
                $was_numeric = false;
            }
        }

        return false;
    }

    private function getElementAt($position, $number): string
    {
        $tmp = substr($number, $position);
        $length = 1;
        $depth = 0;

        foreach (str_split($tmp) as $pos => $chr) {
            if ('[' === $chr) {
                ++$depth;
            }
            if (']' === $chr) {
                --$depth;

                if (0 === $depth) {
                    $length = $pos + 1;
                    break;
                }

                if (-1 === $depth) {
                    $length = $pos;
                    break;
                }
            }

            if (',' === $chr && 0 === $depth) {
                $length = $pos;
                break;
            }

            // echo $chr . ' - ' . $depth . PHP_EOL;
        }

        return substr($number, $position, $length);
    }

    private function getLeftRegularFrom($position, $number): bool|int
    {
        $tmp = substr($number, 0, $position);
        $tmp = strrev($tmp);

        $was_numeric = false;

        foreach (str_split($tmp) as $pos => $chr) {
            if (is_numeric($chr)) {
                $was_numeric = true;
            } else {
                if ($was_numeric) {
                    return \strlen($tmp) - $pos; // (int) $this->getElementAt(strlen($tmp) - $pos, $number);
                }

                $was_numeric = false;
            }
        }

        return false;
    }

    private function getRightRegularFrom($position, $number): bool|int
    {
        $element = $this->getElementAt($position, $number);

        $tmp = substr($number, $position);
        $tmp = substr($tmp, \strlen($element));

        foreach (str_split($tmp) as $pos => $chr) {
            if (is_numeric($chr)) {
                return $position + \strlen($element) + $pos; // (int) $this->getElementAt($pos, $tmp);
            }
        }

        return false;
    }

    private function split($number, $pos): string
    {
        $element = $this->getElementAt($pos, $number);

        $p1 = floor((int) $element / 2);
        $p2 = ceil((int) $element / 2);

        $newNumber = substr($number, 0, $pos);
        $newNumber .= $this->add($p1, $p2);
        $newNumber .= substr($number, $pos + \strlen($element));

        return $newNumber;
    }

    private function explode($number, $pos): string
    {
        $element = $this->getElementAt($pos, $number);

        $tmp = str_replace(['[', ']'], ['', ''], $element);
        [$p1, $p2] = explode(',', $tmp);

        $left = $this->getLeftRegularFrom($pos, $number);
        $right = $this->getRightRegularFrom($pos, $number);

        if ($left) {
            // [[[[0,7],4],[7,[[8,4],9]]],[1,1]]

            // [[[[0,7],4],[

            // echo 'have left ' . $left . PHP_EOL;
            $oldLeft = (int) $this->getElementAt($left, $number);
            $newLeft = $oldLeft + (int) $p1;

            $newNumber = substr($number, 0, $left);
            $newNumber .= $newLeft;
            // $newNumber .= ' | ';
            $newNumber .= substr($number, $left + \strlen((string) $oldLeft), $pos - ($left + \strlen((string) $oldLeft)));
        // $newNumber .= ' | ';
        // $newNumber .= '0';

        // $newNumber .= (int) $this->getElementAt($right, $number) + (int) $p2;
        } else {
            // echo 'dont left ' . $left . PHP_EOL;
            $newNumber = substr($number, 0, $pos);
            // $newNumber .= '0';
        }

        $newNumber .= '0';
        // return $newNumber;

        if ($right) {
            $oldRight = $this->getElementAt($right, $number);
            $newRight = (int) $this->getElementAt($right, $number) + (int) $p2;

            $newNumber .= substr($number, $pos + \strlen($element), $right - ($pos + \strlen($element)));
            $newNumber .= $newRight;
            $newNumber .= substr($number, $right + \strlen($oldRight));
        } else {
            $newNumber .= substr($number, $pos + \strlen($element));
        }

        return $newNumber;
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function magnitude($number): int
    {
        return 0;
    }

    public function partOne(): string
    {
        /*
        $a = '[[[[0,7],4],[7,[[8,4],9]]],[1,1]]';
        $b = $this->explode($a, $this->shouldExplode($a));

        //[[[[0,7],4],[ | 15,  [0   ,13]]],[1,1]]
        //[[[[0,7],4],[ | 15, | 0 | ,13]]],[1,1]]

        var_dump($b);

        return 0;

        //*/

        $number = array_shift($this->lines);

        foreach ($this->lines as $b) {
            $number = $this->add($number, $b);

            $run = true;

            while ($run) {
                if ($e = $this->shouldExplode($number)) {
                    $number = $this->explode($number, $e);
                    echo 'after explode'.\PHP_EOL;
                    var_dump($number);
                    continue;
                }

                if ($pos = $this->shouldSplit($number)) {
                    $number = $this->split($number, $pos);
                    echo 'after split'.\PHP_EOL;
                    var_dump($number);
                    continue;
                }

                $run = false;
            }
        }

        var_dump($number);

        /*
        after addition: [[[[[4,3],4],4],[7,[[8,4],9]]],[1,1]]
                        [[[[[4,3],4],4],[7,[[8,4],9]]],[1,1]]

        after explode:  [[[[0,7],4],[7,[[8,4],9]]],[1,1]]
                        [[[[0,7],4],[7,[[8,4],9]]],[1,1]]

        after explode:  [[[[0,7],4],[15,[0,13]]],[1,1]]
                        [[[[0,7],4],[15,13]]],[1,1]]

        after split:    [[[[0,7],4],[[7,8],[0,13]]],[1,1]]
                        [[[[0,7],4],[[7,8],[0,13]]],[1,1]]


        after split:    [[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]
                        [[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]

        after explode:  [[[[0,7],4],[[7,8],[6,0]]],[8,1]]
                        [[[[0,7],4],[[7,8],[6,0]]],[8,1]]

        [[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]
        [[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]


        [[[[6,6],[7,6]],[[7,7],[7,0]]],[[[7,7],[7,7]],[[7,8],[9,9]]]]
        [[[[6,6],[7,6]],[[7,7],[7,0]]],[[[7,7],[7,7]],[[7,8],[9,9]]]]


            */

        return $number;
    }

    public function partTwo(): string
    {
        return '0';
    }
}
