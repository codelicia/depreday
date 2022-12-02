<?php

declare(strict_types=1);

namespace Codelicia\Depreday\UI;

use DateInterval;
use Exception;
use Psl;
use Symfony\Component\Console\Output\OutputInterface;

use function array_rand;
use function is_int;
use function sprintf;

final class Message
{
    private const SUCCESS = [
        'Oh, you don’t have any deprecations, congrats!',
        'Too bad we don\'t have any deprecation anniversary to commemorate!',
        'You have no deprecations, you are a legend!',
    ];

    public function findingDeprecation(OutputInterface $output, string $directory): void
    {
        $output->writeln(Psl\Str\format("\nFinding deprecations in the directory: <info>%s</info>\n\n", $directory));
    }

    public function deprecationFound(
        OutputInterface $output,
        string $fileRealPath,
        int $cursorPosition,
        string $phrase,
        DateInterval $dateInterval,
    ): void {
        if ($dateInterval->days === 0) {
            return;
        }

        Psl\invariant(is_int($dateInterval->days), 'Expected $dataInterval->days to be an integer.');

        $output->writeln(sprintf('<info>%s</info>:<fg=yellow>%s</>', $fileRealPath, $cursorPosition));
        $output->writeln(sprintf($phrase, '<fg=red>' . $dateInterval->days . '</>'));
        $output->writeln('');
    }

    /** @throws Exception */
    public function success(OutputInterface $output): void
    {
        $output->writeln(sprintf("%s\n\n", array_rand(self::SUCCESS)));
    }

    public function done(OutputInterface $output): void
    {
        $output->writeln('done.');
    }
}
