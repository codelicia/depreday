<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Console;

use DateTimeImmutable;
use Malukenho\Depreday\Bin\Find;
use Malukenho\Depreday\Bin\Grep;
use Malukenho\Depreday\FileLine;
use Malukenho\Depreday\Git\Blame;
use Malukenho\Depreday\UI\Logo;
use Malukenho\Depreday\UI\Phrases;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function array_map;
use function getcwd;
use function preg_match;
use function sprintf;

final class App
{
    public function __invoke(InputInterface $input, OutputInterface $output) : int
    {
        $grep        = new Grep();
        $gitBlame    = new Blame();
        $currentDate = new DateTimeImmutable('now');
        $phrases     = new Phrases;

        array_map([$output, 'writeln'], Logo::logo());

        // TODO: make it configurable?
        // Make it work as just information?
        // Configure it to fail when a certain amount of days pass? or configure it on the comment itself?
        $ls          = new Find(getcwd(), ['php']);
        $listOfFiles = $ls(['vendor', 'var', 'cache', 'node_modules']);

        $output->writeln("\nFinding deprecations in the directory: <info>" . getcwd() . "</info>\n\n");

        /** @var FileLine[] $files */
        $files = $grep('@deprecated', $listOfFiles);

        foreach ($files as $file) {
            $cursorPosition = $file->line() + 1;
            $blameOutput    = $gitBlame($file->getRealPath(), $cursorPosition);

            // TODO: move regex after getting the git blame output
            $regexForDateExtraction = '/.+\(.+(\d{4}-\d{2}-\d{2}) /';
            preg_match($regexForDateExtraction, $blameOutput, $matches);
            $lastChange = DateTimeImmutable::createFromFormat('Y-m-d', $matches[1]);

            $diff = $lastChange->diff($currentDate);

            if ($diff->days === 0) {
                continue;
            }

            $output->writeln(sprintf('<info>%s</info>:<fg=yellow>%s</>', $file->getRealPath(), $cursorPosition));
            $output->writeln(sprintf($phrases->random(), '<fg=red>' . $diff->days . '</>'));
            $output->writeln('');
        }

        return 0;
    }
}
