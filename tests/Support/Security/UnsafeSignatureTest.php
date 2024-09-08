<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Support\Security;

use Beeyev\Thumbor\Support\Security\UnsafeSignature;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * @internal
 */
#[CoversClass(UnsafeSignature::class)]
final class UnsafeSignatureTest extends AbstractTestCase
{
    public function testSign(): void
    {
        $signature = (new UnsafeSignature())->sign('dummy');

        self::assertSame('unsafe', $signature);
    }
}
