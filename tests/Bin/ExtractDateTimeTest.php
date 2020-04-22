<?php

declare(strict_types=1);

namespace CodeliciaTest\Depreday\Bin;

use Codelicia\Depreday\Bin\ExtractDateTime;
use PHPUnit\Framework\TestCase;

final class ExtractDateTimeTest extends TestCase
{
    /**
     * @test
     * @dataProvider validLines
     */
    public function extracts_correct_date(string $line, string $expected) : void
    {
        $extractor = new ExtractDateTime();

        self::assertSame($expected, $extractor($line)->format('Y-m-d'));

    }

    public function validLines(): array
    {
        return [
            [
                '99ede2 (malukenho 2020-02-27 314)      * @deprecated blah blah',
                '2020-02-27'
            ],
            [
                '90777a (malukenho 1993-08-25 314)      * @deprecated (a 1212-12-12)',
                '1993-08-25'
            ],
        ];
    }
}
