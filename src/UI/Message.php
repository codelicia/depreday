<?php

declare(strict_types=1);

namespace Codelicia\Depreday\UI;

use DateInterval;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

use function count;
use function random_int;
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
        $output->writeln("\nFinding deprecations in the directory: <info>" . $directory . "</info>\n\n");
    }

    public function deprecationFound(
        OutputInterface $output,
        string $fileRealPath,
        int $cursorPosition,
        string $phrase,
        DateInterval $dateInterval
    ): void {
        if ($dateInterval->days === 0) {
            return;
        }

        Assert::integer($dateInterval->days);

        $output->writeln(sprintf('<info>%s</info>:<fg=yellow>%s</>', $fileRealPath, $cursorPosition));
        $output->writeln(sprintf($phrase, '<fg=red>' . $dateInterval->days . '</>'));
        $output->writeln('');
    }

    public function success(OutputInterface $output): void
    {
        $output->writeln(sprintf("%s\n\n", self::SUCCESS[random_int(0, count(self::SUCCESS) - 1)]));
    }

    public function done(OutputInterface $output): void
    {
        $output->writeln('done.');
    }
}
