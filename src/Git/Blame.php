<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Git;

use Symfony\Component\Process\Process;
use function trim;

final class Blame
{
    public function __invoke(string $fileRealPath, int $cursorPosition) : string
    {
        $output = (new Process(['git', 'blame', '--date=short', '-L', $cursorPosition . ',+1', '--', $fileRealPath]))
            ->mustRun()
            ->getOutput();

        return trim($output);
    }
}
