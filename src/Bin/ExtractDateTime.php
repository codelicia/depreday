<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Psl;

use function preg_match;

final class ExtractDateTime
{
    private const GIT_BLAME_DATE_TIME = '/.+\(.+(\d{4}-\d{2}-\d{2}) /';

    public function __invoke(string $content): DateTimeImmutable
    {
        Assert::regex($content, self::GIT_BLAME_DATE_TIME);

        preg_match(self::GIT_BLAME_DATE_TIME, $content, $matches);

        Psl\invariant(array_key_exists(1, $matches), 'Expected $matches[1] to exists.');

        $date = DateTimeImmutable::createFromFormat('Y-m-d', $matches[1]);

        Psl\invariant(false !== $date, 'Malformed DateTimeImmutable created.');

        return $date;
    }
}
