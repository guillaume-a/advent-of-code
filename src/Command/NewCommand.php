<?php

declare(strict_types=1);

namespace Joky\AdventOfCode\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'aoc:new')]
class NewCommand extends Command
{
    protected function configure(): void
    {
        $this
          ->addArgument('year', InputArgument::REQUIRED, 'Which year?')
          ->addArgument('day', InputArgument::REQUIRED, 'Which day?')
          ->setDescription('Create boilerplate for a new challenge')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = $input->getArgument('year');
        assert(is_string($year));
        $dayArg = $input->getArgument('day');
        assert(is_string($dayArg) || is_int($dayArg));
        $day = str_pad((string) $dayArg, 2, '0', \STR_PAD_LEFT);

        $yearDir = \sprintf(__DIR__.'/../Challenges/Year%s', $year);
        $inputsDir = \sprintf('%s/inputs', $yearDir);
        $exampleDir = \sprintf('%s/example', $inputsDir);
        $customDir = \sprintf('%s/custom', $inputsDir);

        // Create directories if they don't exist
        if (!is_dir($yearDir)) {
            mkdir($yearDir, 0755, true);
            $output->writeln(\sprintf('<info>Created directory: Year%s</info>', $year));
        }

        if (!is_dir($exampleDir)) {
            mkdir($exampleDir, 0755, true);
            $output->writeln('<info>Created directory: inputs/example</info>');
        }

        if (!is_dir($customDir)) {
            mkdir($customDir, 0755, true);
            $output->writeln('<info>Created directory: inputs/custom</info>');
        }

        // Create challenge class file
        $classFile = \sprintf('%s/Day%s.php', $yearDir, $day);
        if (file_exists($classFile)) {
            $output->writeln(\sprintf('<error>Challenge class already exists: Day%s.php</error>', $day));

            return Command::FAILURE;
        }

        $classContent = $this->generateClassContent($year, $day);
        file_put_contents($classFile, $classContent);
        $output->writeln(\sprintf('<info>Created challenge class: Day%s.php</info>', $day));

        // Create input files
        $exampleInputFile = \sprintf('%s/%s.txt', $exampleDir, $day);
        if (!file_exists($exampleInputFile)) {
            file_put_contents($exampleInputFile, '');
            $output->writeln(\sprintf('<info>Created example input: example/%s.txt</info>', $day));
        }

        $customInputFile = \sprintf('%s/%s.txt', $customDir, $day);
        if (!file_exists($customInputFile)) {
            file_put_contents($customInputFile, '');
            $output->writeln(\sprintf('<info>Created custom input: custom/%s.txt</info>', $day));
        }

        // Create or update answers.json
        $answersFile = \sprintf('%s/answers.json', $exampleDir);
        if (file_exists($answersFile)) {
            $content = file_get_contents($answersFile);
            $answers = json_decode($content !== false ? $content : '', true);
        } else {
            $answers = [];
        }

        if (!is_array($answers)) {
            $answers = [];
        }

        if (!\array_key_exists($day, $answers)) {
            $answers[$day] = [
                'part1' => '',
                'part2' => '',
            ];
            ksort($answers);
            file_put_contents($answersFile, json_encode($answers, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES).\PHP_EOL);
            $output->writeln('<info>Updated answers.json</info>');
        }

        $output->writeln(\sprintf('<comment>Boilerplate created for Year %s, Day %s</comment>', $year, $day));

        return Command::SUCCESS;
    }

    private function generateClassContent(string $year, string $day): string
    {
        return <<<PHP
<?php

namespace Joky\AdventOfCode\Challenges\Year{$year};

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day{$day} extends ChallengeBase {

  public function partOne(): string {
    // TODO: Implement partOne
    return '';
  }

  public function partTwo(): string {
    // TODO: Implement partTwo
    return '';
  }
}

PHP;
    }
}
