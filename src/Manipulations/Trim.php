<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Stringable;

/**
 * Trim.
 *
 * Removes surrounding space in images using the top-left pixel color by default.
 * Trim surrounding space from the thumbnail. The top-left corner of the
 * image is assumed to contain the background color. To specify otherwise,
 * pass either 'top-left' or 'bottom-right' as the $colourSource argument.
 * For tolerance the euclidean distance between the colors of the reference pixel
 * and the surrounding pixels is used. If the distance is within the
 * tolerance, they'll get trimmed. For an RGB image the tolerance would
 * be within the range 0-442.
 *
 * @see https://thumbor.readthedocs.io/en/latest/usage.html#trim
 */
class Trim implements Stringable
{
    public const TOP_LEFT = 'top-left';
    public const BOTTOM_RIGHT = 'bottom-right';
    public const COLOR_TOLERANCE_MIN = 0;
    public const COLOR_TOLERANCE_MAX = 442;
    private const PARAMETER_NAME = 'trim';

    /** @var self::BOTTOM_RIGHT|self::TOP_LEFT|null */
    private string|null $colorSource = null;

    /** @var int<self::COLOR_TOLERANCE_MIN, self::COLOR_TOLERANCE_MAX>|null */
    private int|null $colorTolerance = null;

    /**
     * @param self::BOTTOM_RIGHT|self::TOP_LEFT|null                         $colorSource    Possible values are Trim::TOP_LEFT, Trim::BOTTOM_RIGHT
     * @param int<self::COLOR_TOLERANCE_MIN, self::COLOR_TOLERANCE_MAX>|null $colorTolerance Range between Trim::TOLERANCE_MIN - Trim::TOLERANCE_MAX
     */
    public function __construct(string|null $colorSource = null, int|null $colorTolerance = null)
    {
        if ($colorSource !== null) {
            $this->setColorSource($colorSource);
        }

        if ($colorTolerance !== null) {
            $this->colorTolerance($colorTolerance);
        }
    }

    /**
     * Removes surrounding space in images using top-left pixel color
     */
    public function topLeft(): self
    {
        $this->setColorSource(self::TOP_LEFT);

        return $this;
    }

    /**
     * Removes surrounding space in images using bottom-right pixel color
     */
    public function bottomRight(): self
    {
        $this->setColorSource(self::BOTTOM_RIGHT);

        return $this;
    }

    /**
     * Color tolerance
     * The euclidean distance between the colors of the reference pixel and the surrounding pixels is used.
     * If the distance is within the tolerance, they’ll get trimmed. For an RGB image the tolerance would be within the range 0-442.
     *
     * @param int<self::COLOR_TOLERANCE_MIN, self::COLOR_TOLERANCE_MAX> $colorTolerance Range between 0 - 442
     */
    public function colorTolerance(int $colorTolerance): self
    {
        if ($colorTolerance < self::COLOR_TOLERANCE_MIN || $colorTolerance > self::COLOR_TOLERANCE_MAX) {
            throw new ThumborInvalidArgumentException(sprintf('Color tolerance value must be between %d and %d. Given: `%d`', self::COLOR_TOLERANCE_MIN, self::COLOR_TOLERANCE_MAX, $colorTolerance));
        }

        if ($this->colorTolerance !== null) {
            throw new ThumborInvalidArgumentException("Color tolerance has already been set. Current value: `{$this->colorTolerance}`, Given: `{$colorTolerance}`");
        }

        $this->colorTolerance = $colorTolerance;

        return $this;
    }

    private function setColorSource(string $colorSource): void
    {
        if (!in_array($colorSource, [self::TOP_LEFT, self::BOTTOM_RIGHT], true)) {
            throw new ThumborInvalidArgumentException("Incorrect color source value provided. Given: `{$colorSource}`");
        }

        if ($this->colorSource !== null) {
            throw new ThumborInvalidArgumentException("Color source has already been set. Current value: `{$this->colorSource}`, Given: `{$colorSource}`");
        }

        $this->colorSource = $colorSource;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        $result = array_filter([self::PARAMETER_NAME, $this->colorSource, $this->colorTolerance], static fn(int|string|null $value): bool => $value !== null);

        return implode(':', $result);
    }
}
