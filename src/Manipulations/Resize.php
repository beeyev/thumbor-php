<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Size / Resize.
 *
 * @see \Beeyev\Thumbor\Thumbor::resize()
 */
class Resize
{
    public const ORIG = 'orig';
    protected ?string $width = null;
    protected ?string $height = null;

    public function resize($width = null, $height = null): Resize
    {
        if ($width !== null) {
            $this->width = (string)$width;
        }
        if ($height !== null) {
            $this->height = (string)$height;
        }

        return $this;
    }

    public function getResize(): ?string
    {
        if (!$this->width && !$this->height) {
            return null;
        }

        return implode('x', [$this->width, $this->height]);
    }

    public function noResize(): Resize
    {
        return new static();
    }
}
