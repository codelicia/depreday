<?php

declare(strict_types=1);

namespace Codelicia\Depreday\Bin;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use function preg_match;

final class ExtractDateTime
{
    private const GIT_BLAME_DATE_TIME = '/.+\(.+(\d{4}-\d{2}-\d{2}) /';

    public function __invoke(string $content) : DateTimeImmutable
    {
        Assert::regex($content, self::GIT_BLAME_DATE_TIME);

        preg_match(self::GIT_BLAME_DATE_TIME, $content, $matches);

        Assert::keyExists($matches, 1);

        $date = DateTimeImmutable::createFromFormat('Y-m-d', $matches[1]);

        Assert::notFalse($date);

        return $date;
    }
}
