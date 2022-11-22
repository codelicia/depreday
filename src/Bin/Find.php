<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use Symfony\Component\Finder\Finder;
use Psl\Filesystem;
use Psl\Vec;
use Psl\Str;

final class Find
{
    /**
     * @psalm-param non-empty-string $directoryOrFile
     * @psalm-param list<string> $supportedExtensions
     */
    public function __construct(
        private readonly string $directoryOrFile,
        private readonly array $supportedExtensions
    ) {
    }

    private function getDirectory(): string
    {
        return Filesystem\is_directory($this->directoryOrFile)
            ? $this->directoryOrFile
            : Filesystem\get_directory($this->directoryOrFile);
    }

    /** @return string[] */
    private function getFeatureMatch(): array
    {
        return Filesystem\is_directory($this->directoryOrFile)
            ? Vec\map($this->supportedExtensions, static fn ($x) => Str\format('*.%s', $x))
            : [Filesystem\get_basename($this->directoryOrFile)];
    }

    /** @psalm-param list<string> $excludeDirs */
    public function __invoke(array $excludeDirs): Finder
    {
        return Finder::create()
            ->files()
            ->exclude($excludeDirs)
            ->in($this->getDirectory())
            ->name($this->getFeatureMatch());
    }
}
