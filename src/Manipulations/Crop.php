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
    /** @var non-empty-string|null */
    private string|null $topLeftXY = null;

    /** @var non-empty-string|null */
    private string|null $bottomRightXY = null;

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

        if (($topLeftX === null && $topLeftY !== null) || ($topLeftX !== null && $topLeftY === null)) {
            throw new ThumborInvalidArgumentException('Crop: Both top-left X and Y coordinates must be set together.');
        }

        if ($topLeftX !== null && $topLeftY !== null) {
            $this->topLeft($topLeftX, $topLeftY);
        }

        if (($bottomRightX === null && $bottomRightY !== null) || ($bottomRightX !== null && $bottomRightY === null)) {
            throw new ThumborInvalidArgumentException('Crop: Both bottom-right X and Y coordinates must be set together.');
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

        if ($this->topLeftXY !== null) {
            throw new ThumborInvalidArgumentException("Crop: Top-left X,Y coordinates have already been set. Current values: `{$this->topLeftXY}`, Given: `{$x}x{$y}`");
        }

        $this->topLeftXY = "{$x}x{$y}";

        return $this;
    }

    public function bottomRight(int $x, int $y): self
    {
        if ($x < 0 || $y < 0) {
            throw new ThumborInvalidArgumentException("Crop: Bottom-right X,Y coordinates must be non-negative integers, Given values: x=`{$x}`, y=`{$y}`");
        }

        if ($this->bottomRightXY !== null) {
            throw new ThumborInvalidArgumentException("Crop: Bottom-right X,Y coordinates have already been set. Current values: `{$this->bottomRightXY}`, Given: `{$x}x{$y}`");
        }

        $this->bottomRightXY = "{$x}x{$y}";

        return $this;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        if ($this->topLeftXY === null && $this->bottomRightXY === null) {
            throw new ThumborInvalidArgumentException('Crop: Top-left and bottom-right coordinates must be set before calling `__toString` method.');
        }

        if ($this->topLeftXY === null) {
            throw new ThumborInvalidArgumentException('Crop: Top-left coordinates must be set before calling `__toString` method.');
        }

        if ($this->bottomRightXY === null) {
            throw new ThumborInvalidArgumentException('Crop: Bottom-right coordinates must be set before calling `__toString` method.');
        }

        // @todo check if this is possible
        return "{$this->topLeftXY}:{$this->bottomRightXY}";
    }
}
