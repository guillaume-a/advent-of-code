<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'aoc:run')]
class RunCommand extends Command
{
    private string $resourceDir;
    private string $day;
    private string $puzzleInput;
    private string $part;

    protected function configure(): void
    {
        $this
          ->addArgument('day', InputArgument::REQUIRED, 'Which day do you want to launch ?')
          ->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'What year is it ?', date('Y'))
          ->addOption('p2', null, InputOption::VALUE_NONE, 'Is it allready part 2 ?')
          ->addOption('custom', 'c', InputOption::VALUE_NONE, 'Do you want to use your custom input ?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->day = str_pad($input->getArgument('day'), 2, '0', \STR_PAD_LEFT);
        $year = $input->getOption('year');
        $this->part = $input->getOption('p2') ? '2' : '1';
        $this->puzzleInput = $input->getOption('custom') ? 'custom' : 'example';
        $this->resourceDir = \sprintf(__DIR__.'/../Challenges/Year%s/inputs', $year);

        $class = \sprintf('Joky\\AdventOfCode\\Challenges\\Year%s\\Day%s',
            $year, $this->day);

        if (!class_exists($class)) {
            $output->writeln('<error>No Challenge found</error>');

            return Command::INVALID;
        }

        // Inputs
        $inputFilename = \sprintf($this->resourceDir.'/%s/%s.txt', $this->puzzleInput, $this->day);

        if (!file_exists($inputFilename)) {
            $output->writeln('<error>No Puzzle input found</error>');

            return Command::INVALID;
        }

        /** @var \Joky\AdventOfCode\Challenges\ChallengeInterface $challenge */
        $challenge = new $class(explode(\PHP_EOL, rtrim(file_get_contents($inputFilename))));
        $methodName = '1' === $this->part ? 'partOne' : 'partTwo';
        $answer = $challenge->$methodName();

        $output->writeln('Your answer is : <info>'.$answer.'</info>');

        $this->testAnswer($output, $answer);

        return Command::SUCCESS;
    }

    private function testAnswer(OutputInterface $output, string $answer): void
    {
        // Check Answers
        $answerFilename = \sprintf($this->resourceDir.'/%s/answers.json', $this->puzzleInput);

        if (!file_exists($answerFilename)) {
            return;
        }

        $answers = json_decode(file_get_contents($answerFilename), true);

        if (!\array_key_exists($this->day, $answers)) {
            return;
        }

        $dayAnswer = $answers[$this->day];
        if (!\array_key_exists('part'.$this->part, $dayAnswer)) {
            return;
        }

        $expectedAnswer = $dayAnswer['part'.$this->part];

        if ($expectedAnswer == $answer) {
            $output->writeln('<info>Answer is correct !</info>');
        } else {
            $output->writeln('Answer is not correct. Expected : <comment>'.$expectedAnswer.'</comment>');
        }
    }
}
