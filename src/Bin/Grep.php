<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use ArrayObject;
use Codelicia\Depreday\FileLine;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Webmozart\Assert\Assert;
use function array_filter;
use function array_keys;
use function array_map;
use function explode;
use function stripos;
use const PHP_EOL;

final class Grep
{
    /**
     * @return FileLine[]|ArrayObject<FileLine>
     *
     * @psalm-return ArrayObject
     */
    public function __invoke(string $pattern, Finder $finder) : ArrayObject
    {
        $collection = new ArrayObject();

        /** @psalm-var SplFileInfo $file */
        foreach ($finder as $file) {
            $lines = explode(PHP_EOL, $file->getContents());

            $cur = array_keys(array_filter(array_map(static fn ($line) => stripos($line, $pattern), $lines)));

            if ($cur === []) {
                continue;
            }

            Assert::keyExists($cur, 0);

            // We need to add +1 to the line number as
            // arrays start by 0 and there is no such thing
            // when we are counting line numbers.
            $collection->append(new FileLine($cur[0] + 1, $file));
        }

        return $collection;
    }
}
