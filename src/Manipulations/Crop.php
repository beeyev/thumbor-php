<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;

/**
 * Crop.
 *
 * The manual crop is entirely optional.
 * This is very useful for applications that provide custom real-time cropping capabilities to their users.
 * This crop is performed before the rest of the operations, so it can be used as a prepare step before resizing and smart-cropping.
 *
 * $topLeftX & $topLeftY - Define the first point is the left-top point of the cropping rectangle.
 * $bottomRightX & $bottomRightY - Define the second point is the right-bottom point.
 *
 * @see https://thumbor.readthedocs.io/en/latest/usage.html#manual-crop
 */
class Crop extends AbstractManipulation implements \Stringable
{
    private int|null $topLeftX = null;
    private int|null $topLeftY = null;
    private int|null $bottomRightX = null;
    private int|null $bottomRightY = null;

    /**
     * @param non-negative-int|null $topLeftX
     * @param non-negative-int|null $topLeftY
     * @param non-negative-int|null $bottomRightX
     * @param non-negative-int|null $bottomRightY
     */
    public function __construct(
        int|null $topLeftX = null,
        int|null $topLeftY = null,
        int|null $bottomRightX = null,
        int|null $bottomRightY = null,
    ) {
        if ($topLeftX !== null && $topLeftY !== null) {
            $this->topLeft($topLeftX, $topLeftY);
        }

        if ($bottomRightX !== null && $bottomRightY !== null) {
            $this->bottomRight($bottomRightX, $bottomRightY);
        }
    }

    public function topLeft(int $x, int $y): self
    {
        if ($x < 0 || $y < 0) {
            throw new ThumborInvalidArgumentException("Crop: Top-left X,Y coordinates must be non-negative integers, Given values: x=`{$x}`, y=`{$y}`");
        }

        if ($this->topLeftX !== null) {
            throw new ThumborInvalidArgumentException("Crop: Top-left X coordinate has already been set. Current value: `{$this->topLeftX}`, Given: `{$x}`");
        }

        if ($this->topLeftY !== null) {
            throw new ThumborInvalidArgumentException("Crop: Top-left Y coordinate has already been set. Current value: `{$this->topLeftY}`, Given: `{$y}`");
        }

        $this->topLeftX = $x;
        $this->topLeftY = $y;

        return $this;
    }

    public function bottomRight(int $x, int $y): self
    {
        if ($x < 0 || $y < 0) {
            throw new ThumborInvalidArgumentException("Crop: Bottom-right X,Y coordinates must be non-negative integers, Given values: x=`{$x}`, y=`{$y}`");
        }

        if ($this->bottomRightX !== null) {
            throw new ThumborInvalidArgumentException("Crop: Bottom-right X coordinate has already been set. Current value: `{$this->bottomRightX}`, Given: `{$x}`");
        }

        if ($this->bottomRightY !== null) {
            throw new ThumborInvalidArgumentException("Crop: Bottom-right Y coordinate has already been set. Current value: `{$this->bottomRightY}`, Given: `{$y}`");
        }

        $this->bottomRightX = $x;
        $this->bottomRightY = $y;

        return $this;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        $isTopLeftCoordinatesUnset = $this->topLeftX === null && $this->topLeftY === null;
        $isBottomRightCoordinatesUnset = $this->bottomRightX === null && $this->bottomRightY === null;

        if ($isTopLeftCoordinatesUnset && $isBottomRightCoordinatesUnset) {
            throw new ThumborInvalidArgumentException('Crop: At least one of the top-left or bottom-right coordinates must be set');
        }

        // @todo check if this is possible
        return "{$this->topLeftX}x{$this->topLeftY}:{$this->bottomRightX}x{$this->bottomRightY}";
    }
}
