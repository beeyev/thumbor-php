<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Trim.
 *
 * @see \Beeyev\Thumbor\Thumbor::trim()
 */
class Trim
{
    public const TOP_LEFT = 'top-left';
    public const BOTTOM_RIGHT = 'bottom-right';
    protected bool $isTrimEnabled = false;
    protected ?string $colorSource = null;
    protected ?int $tolerance = null;

    public function trim(?string $colorSource, ?int $tolerance): Trim
    {
        $this->isTrimEnabled = true;
        $this->colorSource = $colorSource;
        $this->tolerance = $tolerance;

        return $this;
    }

    public function getTrim(): ?string
    {
        if (!$this->isTrimEnabled) {
            return null;
        }

        return implode(':', array_filter(['trim', $this->colorSource, $this->tolerance]));
    }

    public function noTrim(): Trim
    {
        return new static();
    }
}
