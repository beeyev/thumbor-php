<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Crop.
 *
 * @see \Beeyev\Thumbor\Thumbor::crop
 */
class Crop
{
    protected ?int $topLeftX = null;
    protected ?int $topLeftY = null;
    protected ?int $bottomRightX = null;
    protected ?int $bottomRightY = null;

    public function crop(int $topLeftX, int $topLeftY, int $bottomRightX, int $bottomRightY): Crop
    {
        $this->topLeftX = $topLeftX;
        $this->topLeftY = $topLeftY;
        $this->bottomRightX = $bottomRightX;
        $this->bottomRightY = $bottomRightY;

        return $this;
    }

    public function getCrop(): ?string
    {
        // yes, this is a really simple check, but it's enough
        if ($this->topLeftX === null) {
            return null;
        }

        return "{$this->topLeftX}x{$this->topLeftY}:{$this->bottomRightX}x{$this->bottomRightY}";
    }

    public function noCrop(): Crop
    {
        return new static();
    }
}
