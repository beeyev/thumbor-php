<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\SignatureHandler;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\SignatureHandler\SafeSignatureHandler;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * @internal
 */
#[CoversClass(SafeSignatureHandler::class)]
final class SafeSignatureHandlerTest extends AbstractTestCase
{
    public function testSign(): void
    {
        $securityKey = '31337';
        $urlWithoutBase = 'filters:brightness(42,88):sun(43)/i.jpg';
        $expectedSignature = 'k7ZKdIDzfFtf45nIYc12qwcdci4=';

        $signature = (new SafeSignatureHandler($securityKey))->sign($urlWithoutBase);

        self::assertSame($expectedSignature, $signature);

    }

    public function testThrowExceptionIfSecurityKeyIsEmpty(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('The security key cannot be empty.');

        new SafeSignatureHandler(''); // @phpstan-ignore argument.type
    }

    public function testThrowExceptionIfUrlIsEmpty(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessage('The URL cannot be empty.');

        (new SafeSignatureHandler('key'))->sign(''); // @phpstan-ignore argument.type
    }
}
