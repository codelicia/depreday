<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Git;

use Symfony\Component\Process\Process;

final class Blame
{
    public function __invoke(string $fileRealPath, int $cursorPosition) : string
    {
        $output = (new Process(['git', 'blame', '--date=short', '-L', $cursorPosition.',+1', '--', $fileRealPath]))
            ->mustRun()
            ->getOutput();

        return trim($output);
    }
}
