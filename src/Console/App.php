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
use Psl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function is_array;
use function is_string;

final class App
{
    public function __construct(
        private readonly Grep $grep = new Grep(),
        private readonly Blame $gitBlame = new Blame(),
        private readonly Message $message = new Message(),
        private readonly ExtractDateTime $extractDateTime = new ExtractDateTime(),
        private readonly DateTimeImmutable $currentDate = new DateTimeImmutable('now'),
        private readonly Phrases $phrases = new Phrases(),
    ) {
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $deprecationFound = false;
        $currentDirectory = $input->getArgument('dir');
        $extension        = $input->getOption('extension');
        $exclude          = $input->getOption('exclude');

        Psl\invariant(is_array($exclude), '$exclude must be an array.');
        Psl\invariant(is_string($extension), '$extension must be a string.');
        Psl\invariant(is_string($currentDirectory), '$currentDirectory must be a string.');

        array_map([$output, 'writeln'], Logo::logoMap());

        $this->message->findingDeprecation($output, $currentDirectory);

        /** @psalm-var list<non-empty-string> $exclude */
        $ls          = new Find($currentDirectory, [$extension]);
        $listOfFiles = $ls($exclude);

        /** @var FileLine[] $files */
        $files = $this->grep->__invoke('@deprecated', $listOfFiles);

        foreach ($files as $file) {
            $blameOutput = $this->gitBlame->__invoke($file->getRealPath(), $file->line);
            $lastChange  = $this->extractDateTime->__invoke($blameOutput);

            $deprecationFound = true;

            $this->message->deprecationFound(
                $output,
                $file->getRelativePathname(),
                $file->line,
                $this->phrases->random(),
                $lastChange->diff($this->currentDate)
            );
        }

        if ($deprecationFound === false) {
            $this->message->success($output);
        }

        $this->message->done($output);

        return Command::SUCCESS;
    }
}
