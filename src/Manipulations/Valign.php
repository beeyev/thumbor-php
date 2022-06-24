<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Vertical Align.
 *
 * @see \Beeyev\Thumbor\Thumbor::valign()
 */
class Valign
{
    public const TOP = 'top';
    public const MIDDLE = 'middle';
    public const BOTTOM = 'bottom';
    protected ?string $valign = null;

    public function valign(string $valign): Valign
    {
        $this->valign = $valign;

        return $this;
    }

    public function getValign(): ?string
    {
        return $this->valign;
    }

    public function noValign(): Valign
    {
        return new static();
    }
}
