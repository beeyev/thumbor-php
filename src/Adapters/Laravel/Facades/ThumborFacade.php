<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Adapters\Laravel\Facades;

use Beeyev\Thumbor\Thumbor;
use Illuminate\Support\Facades\Facade;

class ThumborFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Thumbor::class;
    }
}
