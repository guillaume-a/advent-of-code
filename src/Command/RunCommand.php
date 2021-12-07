<?php

namespace Joky\AdventOfCode\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command {

  protected static $defaultName = 'aoc:run';

  protected function configure(): void
  {
    $this
      ->addArgument('day', InputArgument::REQUIRED, 'Which day do you want to launch ?')
      ->addOption('part2', null, InputOption::VALUE_NONE, 'Is it allready part 2 ?')
      ->addOption('input', 'i', InputOption::VALUE_OPTIONAL, 'Do you want example input or other name ?', 'example')
      ->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'What year is it ?', date('Y'))
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $day = str_pad($input->getArgument('day'), 2, '0', STR_PAD_LEFT);
    $year = $input->getOption('year');
    $part = $input->getOption('part2') ? '2' : '1';
    $puzzleInput = $input->getOption('input');

    $class = sprintf('Joky\\AdventOfCode\\Challenges\\Year_%s\\Day_%s\\Challenge', $year, $day);

    if(!class_exists($class)) {
      $output->writeln('<error>No Challenge found</error>');
      return Command::INVALID;
    }

    // Inputs
    $resourcesDir = sprintf(__DIR__ . '/../../resources/%s', $year);
    $inputFilename = sprintf($resourcesDir . '/%s/inputs/%s.txt', $puzzleInput, $day);

    if(!file_exists($inputFilename)) {
      $output->writeln('<error>No Puzzle input found</error>');
      return Command::INVALID;
    }

    /** @var \Joky\AdventOfCode\Challenges\ChallengeInterface $challenge */
    $challenge = new $class(explode(PHP_EOL, file_get_contents($inputFilename)));
    $answer = $challenge->{'part' . $part}();

    $output->writeln('Your answer is : <info>' . $answer . '</info>');

    // Check Answers
    $answerFilename = sprintf($resourcesDir . '/%s/answers/%s-%s.txt', $puzzleInput, $day, $part);

    if(file_exists($answerFilename)) {
      $expectedAnswer = file_get_contents($answerFilename);
      if($expectedAnswer == $answer) {
        $output->writeln('<info>Answer is correct !</info>');
      } else {
        $output->writeln('Answer is not correct. Expected : <error>' . $expectedAnswer . '</error>');
      }

      return Command::INVALID;
    }

    return Command::SUCCESS;
  }
}