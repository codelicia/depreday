<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use ArrayObject;
use Codelicia\Depreday\FileLine;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;
use function array_filter;
use function array_keys;
use function array_map;
use function explode;
use function stripos;
use const PHP_EOL;

final class Grep
{
    /** @return FileLine[]|ArrayObject<FileLine> */
    public function __invoke(string $pattern, Finder $finder) : ArrayObject
    {
        $collection = new ArrayObject();
        foreach ($finder as $file) {
            $lines = explode(PHP_EOL, $file->getContents());

            $a = array_keys(array_filter(array_map(static fn ($line) => stripos($line, $pattern), $lines)));

            if ($a === []) {
                continue;
            }

            Assert::keyExists($a, 0);

            // We need to add +1 to the line number as
            // arrays start by 0 and there is no such thing
            // when we are counting line numbers.
            $collection->append(new FileLine($a[0] + 1, $file));
        }

        return $collection;
    }
}
