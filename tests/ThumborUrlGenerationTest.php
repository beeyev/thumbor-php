<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Thumbor;

/**
 * @internal
 * @coversNothing
 */
final class ThumborUrlGenerationTest extends TestCase
{
    const SECURITY_KEY = '31337';
    const BASE_URL = 'https://img.example.com';
    const IMAGE_URL = 'abc/yozhik.jpg';

    public function testItChecksSecurityKeyAndBaseUrlParameters()
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl(self::IMAGE_URL);
        static::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->baseUrl(self::BASE_URL);
        static::assertSame(self::BASE_URL . '/unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->securityKey(self::SECURITY_KEY);
        static::assertSame(self::BASE_URL . '/nXc3J50ZiEUqePyYLW4yJq8d1mc=/' . self::IMAGE_URL, $thumbor->get());
    }

    public function testItChecksFinalGet()
    {
        $thumbor = new Thumbor();

        $thumbor->imageUrl(self::IMAGE_URL);
        static::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());

        static::assertSame('unsafe/123/' . self::IMAGE_URL, $thumbor->get('123/' . self::IMAGE_URL));
    }

    public function testItChecksFinalGetException()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        static::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());
    }
}
