<?php

declare(strict_types=1);

namespace Codelicia\Depreday;

use Symfony\Component\Finder\SplFileInfo;

final class FileLine
{
    public function __construct(
        public readonly int $line,
        private readonly SplFileInfo $file
    ) {
    }

    public function getRelativePathname(): string
    {
        return $this->file->getRelativePathname();
    }

    public function getRealPath(): string
    {
        return $this->file->getRealPath();
    }
}
