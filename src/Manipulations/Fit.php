<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Fit.
 *
 * @see \Beeyev\Thumbor\Thumbor::noResizeOrFit()
 */
class Fit
{
    const FIT_IN = 'fit-in';
    const FULL_FIT_IN = 'full-fit-in';
    const ADAPTIVE_FIT_IN = 'adaptive-fit-in';
    const ADAPTIVE_FULL_FIT_IN = 'adaptive-full-fit-in';
}
