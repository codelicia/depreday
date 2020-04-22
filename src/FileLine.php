<?php

declare(strict_types=1);

namespace Codelicia\Depreday;

use Symfony\Component\Finder\SplFileInfo;

final class FileLine
{
    private int $line;
    private SplFileInfo $file;

    public function __construct(int $line, SplFileInfo $file)
    {
        $this->line = $line;
        $this->file = $file;
    }

    public function line() : int
    {
        return $this->line;
    }

    public function getRelativePathname() : string
    {
        return $this->file->getRelativePathname();
    }

    public function getRealPath() : string
    {
        return $this->file->getRealPath();
    }
}
