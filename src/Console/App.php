<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Console;

use DateTimeImmutable;
use Malukenho\Depreday\Bin\ExtractDateTime;
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

final class App
{
    public function __invoke(InputInterface $input, OutputInterface $output) : int
    {
        $grep             = new Grep();
        $gitBlame         = new Blame();
        $message          = new Message();
        $extractDateTime  = new ExtractDateTime();
        $currentDate      = new DateTimeImmutable('now');
        $phrases          = new Phrases;
        $currentDirectory = $input->getArgument('dir');

        array_map([$output, 'writeln'], Logo::logo());

        $message->findingDeprecation($output, $currentDirectory);

        $ls          = new Find($currentDirectory, [$input->getArgument('extension')]);
        $listOfFiles = $ls($input->getArgument('exclude'));

        /** @var FileLine[] $files */
        $files = $grep('@deprecated', $listOfFiles);

        foreach ($files as $file) {
            $blameOutput = $gitBlame($file->getRealPath(), $file->line());
            $lastChange = $extractDateTime($blameOutput);

            $message->deprecationFound($output, $file->getRealPath(), $file->line(), $phrases->random(), $lastChange->diff($currentDate));
        }

        $message->done($output);

        return 0;
    }
}
