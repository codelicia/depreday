<?php

declare(strict_types=1);

namespace Malukenho\Depreday\UI;

final class Logo
{
    private const LOGO = [
        [''],
        ['   )  (  )  ('],
        ['  (^)(^)(^)(^)'],
        ['  _i__i__i__i_'],
        [' (____________)          Depreday'],
        [' |####|>o<|###|      Let\'s Party on!'],
        [' (____________)'],
        [''],
    ];

    /** @psalm-return list<string> */
    public static function logo(): array
    {
        return self::LOGO;
    }
}
