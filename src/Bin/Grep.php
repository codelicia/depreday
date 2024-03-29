<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use ArrayObject;
use Codelicia\Depreday\FileLine;
use Psl\Str;
use Psl\Vec;
use Symfony\Component\Finder\Finder;

use function stripos;

use const PHP_EOL;

final class Grep
{
    /**
     * @return FileLine[]&ArrayObject<FileLine>
     * @psalm-return ArrayObject
     */
    public function __invoke(string $pattern, Finder $finder): ArrayObject
    {
        $collection = new ArrayObject();

        foreach ($finder as $file) {
            $lines = Str\split($file->getContents(), PHP_EOL);

            // @todo(malukenho): search for stripos on vendor/spl dir
            $cur = Vec\keys(Vec\filter(Vec\map($lines, static fn (string $line) => stripos($line, $pattern))));

            if ($cur === []) {
                continue;
            }

            // We need to add +1 to the line number as
            // arrays start by 0 and there is no such thing
            // as a line 0.
            $collection->append(new FileLine($cur[0] + 1, $file));
        }

        return $collection;
    }
}
