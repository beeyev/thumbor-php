<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Support;

use Beeyev\Thumbor\Support\Security;
use Beeyev\Thumbor\Test\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SecurityTest extends TestCase
{
    public function testItChecksSecuritySign()
    {
        $securityKey = '31337';
        $urlWithoutBase = 'filters:brightness(42,88):sun(43)/i.jpg';
        $expectedSignature = 'k7ZKdIDzfFtf45nIYc12qwcdci4=';
        $urlSignature = Security::sign($securityKey, $urlWithoutBase);
        static::assertSame($expectedSignature, $urlSignature);
    }
}
