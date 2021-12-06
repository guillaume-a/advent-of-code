# Advent of Code 2021

This is my attempt to solve [Advent of Code 2021](https://adventofcode.com/2021) puzzles in PHP.

Solutions are not optimized, and are not intended to be.

# Inputs 

In the `inputs` folder, inputs are named with the following pattern : 

```
day-[day]-[dataset].txt
```

Where dataset can be any name.

Each challenge come with `example` and `custom` datasets which corresponds to my own inputs.

You can add or replace with your inputs.

# Challenges

In the `challenges` folder, my personnal implementation for each. Really not optimized, I just want to solve them and have fun.

# Run php script

`day` must be the day (two digits) follow by the part. Ex : 01-1 = day 01, part 1.

`dataset` can be blank (example dataset) or corresponding to a custom dataset.

Bash
```
docker run --rm -ti -v $(pwd):/app/ php:7.4-cli php app/run.php [day] [dataset=example]
```

Fish
```
docker run --rm -ti -v (pwd):/app/ php:7.4-cli php app/run.php [day] [dataset=example]
```