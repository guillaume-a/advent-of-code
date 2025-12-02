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
1. Extend `ChallengeBase` (which implements `ChallengeInterface`)
2. Be placed in `Joky\AdventOfCode\Challenges\Year[YYYY]\Day[DD]` namespace
3. Implement `partOne(): string` and `partTwo(): string` methods

### File Structure
- Challenges: `src/Challenges/Year[YYYY]/Day[DD].php`
- Inputs: `src/Challenges/Year[YYYY]/inputs/[example|custom]/[DD].txt`
- Answers: `src/Challenges/Year[YYYY]/inputs/[example|custom]/answers.json`

## Code Style
- Not optimized for performance - focus on solving puzzles
- Readability over optimization
- Minimal comments unless logic is complex
- Follow PSR-1/PSR-12 standards

### Naming Conventions
- **Classes**: `PascalCase` without underscores (e.g., `NewCommand`, `Day01`, `Year2025`)
- **Methods**: `camelCase` for ALL methods - public, protected, and private (e.g., `partOne()`, `partTwo()`, `generateClassContent()`)
- **Properties**: `camelCase` with type hints (e.g., `private string $resourceDir`, `protected array $lines`)
- **Namespaces**: `PascalCase` without underscores (e.g., `Year2025\Day01`)
- **Files/Directories**: Match class/namespace names without underscores (e.g., `Day01.php`, `Year2025/`)
- **Constants**: `UPPER_SNAKE_CASE`
- **Avoid**: `snake_case` in method names, underscores in class/file/directory names

## When Creating New Challenges
1. Create class in `src/Challenges/Year[YYYY]/Day[DD].php`
2. Extend `ChallengeBase`
3. Implement `partOne(): string` and `partTwo(): string` methods
4. Use `$this->lines` property for input data
5. Create corresponding input/answer files in `Year[YYYY]/inputs/`

## Docker Usage
- Development: Use `php:8.5-cli` image
- Dependencies: Use `composer:2.1` image
- Always mount current directory as `/app` volume

## Testing Approach
- Use example inputs first (default behavior)
- Test with custom inputs using `--custom` flag
- Verify against known answers in `answers/` directory
