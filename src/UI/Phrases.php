<?php

declare(strict_types=1);

namespace Malukenho\Depreday\UI;

use function random_int;

final class Phrases
{
    private const CONGRATULATION = [
        'You are a ninja! You managed to survive as a deprecated code for %s days, congrats! ✨',
        'Happy depreday! We congratulate you for your %s days of survival! 🎂',
        'When I grow up I want to be like you! %s days 🤩',
        'Awesome %s days! At least you are not a bug 🐞',
        'Happy birthday to you 🎶!!! %s days',
    ];

    public function random(): string
    {
        return self::CONGRATULATION[random_int(0, count(self::CONGRATULATION) - 1)];
    }
}
