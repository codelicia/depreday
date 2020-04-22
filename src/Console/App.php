<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Console;

use DateTimeImmutable;
use Malukenho\Depreday\Bin\Find;
use Malukenho\Depreday\Bin\Grep;
use Malukenho\Depreday\FileLine;
use Malukenho\Depreday\Git\Blame;
use Malukenho\Depreday\UI\Logo;
use Malukenho\Depreday\UI\Message;
use Malukenho\Depreday\UI\Phrases;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function array_map;
use function getcwd;
use function preg_match;

final class App
{
    public function __invoke(InputInterface $input, OutputInterface $output) : int
    {
        $grep        = new Grep();
        $gitBlame    = new Blame();
        $message     = new Message();
        $currentDate = new DateTimeImmutable('now');
        $phrases     = new Phrases;
        $currentDir  = getcwd();

        array_map([$output, 'writeln'], Logo::logo());

        $message->findingDeprecation($output, $currentDir);

        // TODO: make it configurable?
        // Make it work as just information?
        // Configure it to fail when a certain amount of days pass? or configure it on the comment itself?
        $ls          = new Find($currentDir, ['php']);
        $listOfFiles = $ls(['vendor', 'var', 'cache', 'node_modules']);

        /** @var FileLine[] $files */
        $files = $grep('@deprecated', $listOfFiles);

        foreach ($files as $file) {
            $blameOutput    = $gitBlame($file->getRealPath(), $file->line());

            // TODO: move regex after getting the git blame output
            $regexForDateExtraction = '/.+\(.+(\d{4}-\d{2}-\d{2}) /';
            preg_match($regexForDateExtraction, $blameOutput, $matches);
            $lastChange = DateTimeImmutable::createFromFormat('Y-m-d', $matches[1]);

            $message->deprecationFound($output, $file->getRealPath(), $file->line(), $phrases->random(), $lastChange->diff($currentDate));
        }

        return 0;
    }
}
