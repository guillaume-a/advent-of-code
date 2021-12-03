# Advent of Code 2021

This is my attempt to solve [Advent of Code 2021](https://adventofcode.com/2021) puzzles in PHP.

Solutions are not optimized, and are not intended to be.

# Inputs 

In the `inputs` folder, inputs are named with the following pattern : 

```
input-[day]-[part].txt
```

Part = 0 : Input in the example.
Part = 1 : Personnal input


# Run php script

Bash
```
docker run --rm -v $(pwd):/app/ php:7.4-cli php app/day-01.php
```

Fish
```
docker run --rm -v (pwd):/app/ php:7.4-cli php app/day-01.php
```