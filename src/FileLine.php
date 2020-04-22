<?php

declare(strict_types=1);

namespace Malukenho\Depreday;

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

    public function getRelativePath() : string
    {
        return $this->file->getRelativePath();
    }

    public function getRealPath() : string
    {
        return $this->file->getRealPath();
    }
}
