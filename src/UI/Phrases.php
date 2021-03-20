<?php

declare(strict_types=1);

namespace Codelicia\Depreday\UI;

use Exception;

use function count;
use function random_int;

final class Phrases
{
    private const CONGRATULATION = [
        'You are a ninja! You managed to survive as a deprecated code for %s days, congrats! ✨',
        'Happy depreday! We congratulate you for your %s days of survival! 🎂',
        'When I grow up I want to be like you! %s days 🤩',
        'Awesome %s days! At least you are not a bug 🐞',
        'Happy birthday to you 🎶!!! %s days',
        'Come on y\'all! This bug guys deserve an applause! %s days',
        'Wow! %s days',
        '%s days? You could have been my mother.',
        'I wish you other %s days of a living deprecation comment!',
        'What if I had %s free days as you do...',
        '%s days ago... a new deprecation comment was born 🙈',
    ];

    /** @throws Exception */
    public function random(): string
    {
        return self::CONGRATULATION[random_int(0, count(self::CONGRATULATION) - 1)];
    }
}
