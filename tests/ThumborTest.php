<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Thumbor;

/**
 * @internal
 * @coversNothing
 */
final class ThumborTest extends TestCase
{
    public function testItChecksIfBaseUrlAcceptsString()
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl('http://seriouscat.com/');
        static::assertSame('http://seriouscat.com', $thumbor->getBaseUrl());
    }

    public function testItChecksIfBaseUrlAcceptsNull()
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl(null);
        static::assertNull($thumbor->getBaseUrl());
    }

    public function testItChecksIfBaseUrlThrowsException()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/is not a string or NULL/');
        $thumbor->baseUrl(new \stdClass());
    }

    public function testItChecksIfSecurityKeyAcceptsString()
    {
        $securityKey = '31337';
        $thumbor = new Thumbor();
        $thumbor->securityKey($securityKey);
        static::assertSame($securityKey, $thumbor->getSecurityKey());
    }

    public function testItChecksIfSecurityKeyAcceptsNull()
    {
        $thumbor = new Thumbor();
        $thumbor->securityKey(null);
        static::assertNull($thumbor->getSecurityKey());
    }

    public function testItChecksIfSecurityKeyThrowsException()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/string, integer or NULL/');
        $thumbor->securityKey(new \stdClass());
    }

    public function testItChecksIfImageUrlIsSet()
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl('/yozhik.jpg');
        static::assertSame('yozhik.jpg', $thumbor->getImageUrl());
    }

    public function it_checks_if_exception_is_thrown_when_imageUrl_is_not_set()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        $thumbor->get();
    }
}
