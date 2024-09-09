<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\SignatureHandler;

use Beeyev\Thumbor\SignatureHandler\UnsafeSignatureHandler;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * @internal
 */
#[CoversClass(UnsafeSignatureHandler::class)]
final class UnsafeSignatureHandlerTest extends AbstractTestCase
{
    public function testSign(): void
    {
        $signature = (new UnsafeSignatureHandler())->sign('dummy');

        self::assertSame('unsafe', $signature);
    }
}
