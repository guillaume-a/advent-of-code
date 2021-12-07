# Advent of Code

This is my attempt to solve [Advent of Code](https://adventofcode.com/) puzzles in PHP.

> /!\ Solutions are not optimized, and are not intended to be.
> 
> This is just me trying to have fun solving puzzles. <3

# Requirements

* Bash or Fish
* Make
* Docker

# Setup

Bash
```
docker run --rm --interactive --tty --volume $(pwd):/app composer:2.1 install
```

Fish
```
docker run --rm --interactive --tty --volume (pwd):/app composer:2.1 install
```

# TODO 

* makefile
* fix-permission script

# Run php script

```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php --help

Usage:
  aoc:run [options] [--] <day>

Arguments:
  day                   Which day do you want to launch ?

Options:
      --part2           Is it allready part 2 ?
  -i, --input[=INPUT]   Do you want example input or other name ? [default: "example"]
  -y, --year[=YEAR]     What year is it ? [default: "2021"]
```

Examples :

Run Day 01, Part 1 for current year with example inputs : 
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1
```

Run Day 01, Part 2 for current year with example inputs :
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1 --part2
```

Run Day 01, Part 2 for current year with `custom` inputs (where `custom` is the folder name, it can be whatever you want) :
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1 --part2 -i custom
```

# Inputs & Answers

In the `resources` folder, inputs are named with the following pattern : 

```
/[YYYY]/[input-name]/inputs/[DD].txt
/[YYYY]/[input-name]/answers/[DD]-[part].txt
```

In the `answers` files, are the expected values for this specific challenge/part.
 
Can be used for futur optimisation.

# Challenges

Each challenge must implements `ChallengeInterface`

And be in the namespace corrersponding to its year/day

`Joky\AdventOfCode\Challenges\Year_[YYYY]\Day_[DD]`