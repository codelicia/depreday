<?php

declare(strict_types=1);

namespace Malukenho\Depreday\Bin;

use ArrayObject;
use Malukenho\Depreday\FileLine;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;
use function array_keys;
use function array_map;
use function explode;
use function stripos;
use const PHP_EOL;

final class Grep
{
    /** @return FileLine[]|ArrayObject<FileLine> */
    public function __invoke(string $pattern, Finder $finder): ArrayObject
    {
        $collection = new ArrayObject();
        foreach ($finder as $file) {
            $lines = explode(PHP_EOL, $file->getContents());

            $a = array_keys(array_filter(array_map(fn ($line) => stripos($line, $pattern), $lines)));

            if ($a === []) {
                continue;
            }

            Assert::keyExists($a, 0);

            $collection->append(new FileLine($a[0], $file));
        }

        return $collection;
    }
}
