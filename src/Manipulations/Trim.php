<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

use Beeyev\Thumbor\Thumbor;

/**
 * Trim.
 *
 * @see Thumbor::trim()
 */
class Trim
{
    public const TOP_LEFT = 'top-left';
    public const BOTTOM_RIGHT = 'bottom-right';
    public const TOLEARNCE_MIN = 0;
    public const TOLEARNCE_MAX = 442;
}
