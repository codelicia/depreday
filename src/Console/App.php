<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Console;

use Codelicia\Depreday\Bin\ExtractDateTime;
use Codelicia\Depreday\Bin\Find;
use Codelicia\Depreday\Bin\Grep;
use Codelicia\Depreday\FileLine;
use Codelicia\Depreday\Git\Blame;
use Codelicia\Depreday\UI\Logo;
use Codelicia\Depreday\UI\Message;
use Codelicia\Depreday\UI\Phrases;
use DateTimeImmutable;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;
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
        $phrases          = new Phrases();
        $currentDirectory = $input->getArgument('dir');
        $extension        = $input->getArgument('extension');
        $exclude          = $input->getArgument('exclude');

        Assert::isArray($exclude);
        Assert::string($extension);
        Assert::string($currentDirectory);

        array_map([$output, 'writeln'], Logo::logoMap());

        $message->findingDeprecation($output, $currentDirectory);

        /** @psalm-var list<string> $exclude */
        $ls          = new Find($currentDirectory, [$extension]);
        $listOfFiles = $ls($exclude);

        /** @var FileLine[] $files */
        $files = $grep('@deprecated', $listOfFiles);

        foreach ($files as $file) {
            $blameOutput = $gitBlame($file->getRealPath(), $file->line());
            $lastChange  = $extractDateTime($blameOutput);

            $message->deprecationFound(
                $output,
                $file->getRealPath(),
                $file->line(),
                $phrases->random(),
                $lastChange->diff($currentDate)
            );
        }

        $message->done($output);

        return 0;
    }
}
