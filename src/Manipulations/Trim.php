<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

class Trim implements ManipulationInterface
{
    /** @var string */
    const TOP_LEFT = 'top-left';
    /** @var string */
    const BOTTOM_RIGHT = 'bottom-right';
    /** @var string|null */
    public $colorSource;
    /** @var int|null */
    public $tolerance;

    /** {@inheritDoc} */
    public function get()
    {
        return '123';
    }

    public function reset(): ManipulationInterface
    {
        return new static();
    }
}
