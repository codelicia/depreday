<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Git;

use Symfony\Component\Process\Process;
use function var_dump;

final class Blame
{
    public function __invoke(string $fileRealPath, int $cursorPosition) : string
    {
        // todo: refactor the $cursorPosition usage
        $output = (new Process(['git', 'blame', '--date=short', '-L', $cursorPosition.','.$cursorPosition, '--', $fileRealPath]))
            ->mustRun()
            ->getOutput();

        return trim($output);
    }
}
