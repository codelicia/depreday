<?php

declare(strict_types=1);

namespace CodeliciaTest\Depreday;

use Codelicia\Depreday\FileLine;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;
use function sys_get_temp_dir;
use function tempnam;
use function uniqid;

final class FileLineTest extends TestCase
{
    /** @test */
    public function success() : void
    {
        $tempFile = tempnam(sys_get_temp_dir(), uniqid('file', true));
        $line     = 1;

        $file     = new SplFileInfo($tempFile, $tempFile, $tempFile);
        $fileLine = new FileLine($line, $file);

        self::assertSame($tempFile, $fileLine->getRelativePathname());
        self::assertSame($tempFile, $fileLine->getRealPath());
        self::assertSame($line, $fileLine->line());
    }
}
