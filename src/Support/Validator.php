<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Support;

class Validator
{
    /**
     * @param mixed $var
     */
    public static function canBeString($var): bool
    {
        return $var === null || is_scalar($var) || (is_object($var) && method_exists($var, '__toString'));
    }
}
