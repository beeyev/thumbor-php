<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Support;

use Beeyev\Thumbor\Support\Security;
use PHPUnit\Framework\TestCase;

class SecurityTest extends TestCase
{
    /** @test */
    public function it_checks_security_sign()
    {
        $securityKey = '31337';
        $urlWithoutBase = 'filters:brightness(42,88):sun(43)/i.jpg';
        $expectedSignature = 'k7ZKdIDzfFtf45nIYc12qwcdci4=';
        $urlSignature = Security::sign($securityKey, $urlWithoutBase);
        $this->assertEquals($expectedSignature, $urlSignature);
    }
}
