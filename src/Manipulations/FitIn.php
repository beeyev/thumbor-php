<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;

class FitIn extends AbstractManipulation implements \Stringable
{
    public const DEFAULT = 'fit-in';
    public const FULL = 'full-fit-in';
    public const ADAPTIVE = 'adaptive-fit-in';
    public const ADAPTIVE_FULL = 'adaptive-full-fit-in';

    /** @var non-empty-string|null */
    private string|null $fitInType = null;

    /**
     * @param self::ADAPTIVE|self::ADAPTIVE_FULL|self::DEFAULT|self::FULL|null $fitInType
     */
    public function __construct(string|null $fitInType = null)
    {
        if ($fitInType !== null) {
            $this->setFitInType($fitInType);
        }
    }

    public function default(): self
    {
        $this->setFitInType(self::DEFAULT);

        return $this;
    }

    public function full(): self
    {
        $this->setFitInType(self::FULL);

        return $this;
    }

    public function adaptive(): self
    {
        $this->setFitInType(self::ADAPTIVE);

        return $this;
    }

    public function adaptiveFull(): self
    {
        $this->setFitInType(self::ADAPTIVE_FULL);

        return $this;
    }

    /**
     * @param non-empty-string $fitInType
     */
    private function setFitInType(string $fitInType): void
    {
        if (!in_array($fitInType, [self::DEFAULT, self::FULL, self::ADAPTIVE, self::ADAPTIVE_FULL], true)) {
            throw new ThumborInvalidArgumentException("FitIn: Invalid fit-in type provided. Given value: {$fitInType}");
        }

        if ($this->fitInType !== null) {
            throw new ThumborInvalidArgumentException("FitIn: Fit-in type is already set. Current value: {$this->fitInType}, Given value: {$fitInType}");
        }

        $this->fitInType = $fitInType;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        if ($this->fitInType === null) {
            throw new ThumborInvalidArgumentException('FitIn: Fit-in type must be set.');
        }

        return $this->fitInType;
    }
}
