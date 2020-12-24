<?php

declare(strict_types=1);

namespace Codelicia\Depreday\UI;

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

    /** @return string[][] */
    public static function logoMap(): array
    {
        return self::LOGO;
    }
}
