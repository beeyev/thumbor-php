<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Thumbor;

/**
 * @internal
 *
 * @coversNothing
 */
final class ThumborTest extends TestCase
{
    public function testItChecksIfBaseUrlAcceptsString(): void
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl('http://seriouscat.com/');
        self::assertSame('http://seriouscat.com', $thumbor->getBaseUrl());
    }

    public function testItChecksIfBaseUrlAcceptsNull(): void
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl(null);
        self::assertNull($thumbor->getBaseUrl());
    }

    public function testItChecksIfSecurityKeyAcceptsString(): void
    {
        $securityKey = '31337';
        $thumbor = new Thumbor();
        $thumbor->securityKey($securityKey);
        self::assertSame($securityKey, $thumbor->getSecurityKey());
    }

    public function testItChecksIfSecurityKeyAcceptsNull(): void
    {
        $thumbor = new Thumbor();
        $thumbor->securityKey(null);
        self::assertNull($thumbor->getSecurityKey());
    }

    public function testItChecksIfImageUrlIsSet(): void
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl('/yozhik.jpg');
        self::assertSame('yozhik.jpg', $thumbor->getImageUrl());
    }

    public function it_checks_if_exception_is_thrown_when_imageUrl_is_not_set(): void
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        $thumbor->get();
    }
}
