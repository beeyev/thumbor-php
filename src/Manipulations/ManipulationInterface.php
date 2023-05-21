<?php

namespace Beeyev\Thumbor\Manipulations;

interface ManipulationInterface
{
    /**
     * @return string|null
     */
    public function get();

    public function reset(): self;
}
