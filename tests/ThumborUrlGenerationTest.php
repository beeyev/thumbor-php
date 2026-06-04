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
final class ThumborUrlGenerationTest extends TestCase
{
    public const SECURITY_KEY = '31337';
    public const BASE_URL = 'https://img.example.com';
    public const IMAGE_URL = 'abc/yozhik.jpg';

    public function testItChecksSecurityKeyAndBaseUrlParameters(): void
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl(self::IMAGE_URL);
        self::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->baseUrl(self::BASE_URL);
        self::assertSame(self::BASE_URL . '/unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->securityKey(self::SECURITY_KEY);
        self::assertSame(self::BASE_URL . '/nXc3J50ZiEUqePyYLW4yJq8d1mc=/' . self::IMAGE_URL, $thumbor->get());
    }

    public function testItChecksFinalGet(): void
    {
        $thumbor = new Thumbor();

        $thumbor->imageUrl(self::IMAGE_URL);
        self::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());

        self::assertSame('unsafe/123/' . self::IMAGE_URL, $thumbor->get('123/' . self::IMAGE_URL));
    }

    public function testItChecksFinalGetException(): void
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        self::assertSame('unsafe/' . self::IMAGE_URL, $thumbor->get());
    }
}
