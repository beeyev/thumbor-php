<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Horizontal Align.
 *
 * @see \Beeyev\Thumbor\Thumbor::halign()
 */
class Halign
{
    public const LEFT = 'left';
    public const CENTER = 'center';
    public const RIGHT = 'right';
    protected ?string $halign = null;

    public function halign(string $halign): Halign
    {
        $this->halign = $halign;

        return $this;
    }

    public function getHalign(): ?string
    {
        return $this->halign;
    }

    public function noHalign(): Halign
    {
        return new static();
    }
}
