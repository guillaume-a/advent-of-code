# Advent of Code

This is my attempt to solve [Advent of Code](https://adventofcode.com/) puzzles in PHP.

> /!\ Solutions are not optimized, and are not intended to be.
> 
> This is just me trying to have fun solving puzzles. <3

# Requirements

* Bash or Fish
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

Bash
```
docker run --rm -ti -v $(pwd):/app/ php:8-cli php app/run.php <day> [--p2] [--year yyyy] [--custom]
```

Fish
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php
```

```
Usage:
  aoc:run [options] [--] <day>

Arguments:
  day                   Which day do you want to launch ?

Options:
  -y, --year[=YEAR]     What year is it ? [default: "2021"]
      --p2              Is it allready part 2 ?
  -c, --custom          Do you want to use your custom input ?
```

Examples :

Run Day 01, Part 1 for current year with example inputs : 
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1
```

Run Day 01, Part 2 for current year with example inputs :
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1 --p2
```

Run Day 01, Part 2 for current year with `custom` inputs:
```
docker run --rm -ti -v (pwd):/app/ php:8-cli php app/run.php 1 --p2 --custom
```

# Inputs

In the `resources` folder, inputs are named with the following pattern : 

```
/[YYYY]/[example|custom]/inputs/[DD].txt
/[YYYY]/[example|custom]/answers/[DD]-[part].txt
```

#Answers

Beide the inputs folder, there is a anwsers.json wwith example answers. You can duplicate it into the custom with correct answers. If you want to refactor code after, you'll still have the correct answers somewhere.

# Challenges

Each challenge must implements `ChallengeInterface`

And be in the class corresponding to its year/day

`Joky\AdventOfCode\Challenges\Year_[YYYY]\Day_[DD]`