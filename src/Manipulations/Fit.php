<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

use Beeyev\Thumbor\Thumbor;

/**
 * Fit.
 *
 * @see Thumbor::noResizeOrFit()
 */
class Fit
{
    public const FIT_IN = 'fit-in';
    public const FULL_FIT_IN = 'full-fit-in';
    public const ADAPTIVE_FIT_IN = 'adaptive-fit-in';
    public const ADAPTIVE_FULL_FIT_IN = 'adaptive-full-fit-in';
}
