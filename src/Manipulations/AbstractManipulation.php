<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

class AbstractManipulation
{
    public static function new(): self
    {
        return new static(); // @phpstan-ignore new.static
    }
}
