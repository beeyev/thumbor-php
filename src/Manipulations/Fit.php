<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Fit in..
 *
 * @see \Beeyev\Thumbor\Thumbor::fit()
 */
class Fit
{
    public const FIT_IN = 'fit-in';
    public const FULL_FIT_IN = 'full-fit-in';
    public const ADAPTIVE_FIT_IN = 'adaptive-fit-in';
    public const ADAPTIVE_FULL_FIT_IN = 'adaptive-full-fit-in';
    protected ?string $fit = null;

    public function fit(string $fit): Fit
    {
        $this->fit = $fit;
        return $this;
    }

    public function getFit(): ?string
    {
        return $this->fit ? $this->fit : null;
    }

    public function noFit(): Fit
    {
        $this->fit = null;
        return $this;
    }
}
