# GitHub Copilot Instructions for Advent of Code Project

## Project Overview
This is a PHP-based Advent of Code challenge solver using Docker for environment management and Symfony Console for CLI commands.

## Architecture
- **Language**: PHP 8.5+
- **Framework**: Symfony Console component
- **Namespace**: `Joky\AdventOfCode`
- **Structure**: PSR-4 autoloading from `src/` directory

## Key Patterns

### Challenge Implementation
All challenges must:
1. Implement `ChallengeInterface`
2. Be placed in `Joky\AdventOfCode\Challenges\Year_[YYYY]\Day_[DD]` namespace
3. Handle both Part 1 and Part 2 of the puzzle

### File Structure
- Challenges: `src/Challenges/Year_[YYYY]/Day_[DD].php`
- Inputs: `resources/[YYYY]/[example|custom]/inputs/[DD].txt`
- Answers: `resources/[YYYY]/[example|custom]/answers/[DD]-[part].txt`

## Code Style
- Not optimized for performance - focus on solving puzzles
- Readability over optimization
- Minimal comments unless logic is complex

## When Creating New Challenges
1. Create class in `src/Challenges/Year_[YYYY]/Day_[DD].php`
2. Implement `ChallengeInterface`
3. Add methods for part 1 and part 2
4. Create corresponding input/answer files in `resources/`

## Docker Usage
- Development: Use `php:8.5-cli` image
- Dependencies: Use `composer:2.1` image
- Always mount current directory as `/app` volume

## Testing Approach
- Use example inputs first (default behavior)
- Test with custom inputs using `--custom` flag
- Verify against known answers in `answers/` directory
