# 🎄 Advent of Code

This is my attempt to solve [Advent of Code](https://adventofcode.com/) puzzles in PHP.

> /!\ Solutions are not optimized, and are not intended to be.
> 
> This is just me trying to have fun solving puzzles. <3

## 📋 Requirements

* Docker
* Make (optional, but recommended)

## 🚀 Quick Start

### Installation

```bash
make install
```

Or manually with Docker:
```bash
docker run --rm -ti --user $(id -u):$(id -g) --volume $(pwd):/app composer:latest install
```

## 📖 Usage

Run `make` or `make help` to see all available commands:

```bash
make
```

### Create a New Challenge

```bash
make new year=2025 day=01
```

This will create:
- Challenge class: `src/Challenges/Year_2025/Day_01.php`
- Example input: `inputs/example/01.txt`
- Custom input: `inputs/custom/01.txt`
- Entry in `answers.json`

### Run a Challenge

```bash
make run year=2025 day=01
```

Or manually with Docker:
```bash
docker run --rm -ti --user $(id -u):$(id -g) -v $(pwd):/app/ php:8.5-cli php app/run.php aoc:run 2025 01
```

### Fix Code Style

```bash
make fix
```

## 📁 Project Structure

### Inputs

Inputs are organized in the following structure:

```
inputs/
├── example/          # Example inputs from the puzzle description
│   └── 01.txt
└── custom/           # Your personal puzzle inputs
    └── 01.txt
```

### Answers

The `answers.json` file contains expected answers for validation:
- **example**: Answers from the puzzle description examples
- **custom**: Your personal puzzle answers (for regression testing after refactoring)

### Challenges

Each challenge must:
- Implement `ChallengeInterface`
- Be in the namespace: `Joky\AdventOfCode\Challenges\Year_[YYYY]\Day_[DD]`
- Implement methods: `partOne()` and `partTwo()`

Example:
```php
namespace Joky\AdventOfCode\Challenges\Year_2025;

class Day_01 implements ChallengeInterface
{
    public function partOne(): string { /* ... */ }
    public function partTwo(): string { /* ... */ }
}
```

## 🛠️ Development

All commands are available through the Makefile. Run `make` to see the full list of available commands with descriptions.