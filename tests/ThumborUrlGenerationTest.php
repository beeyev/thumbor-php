<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class ThumborUrlGenerationTest extends TestCase
{
    const SECURITY_KEY = '31337';
    const BASE_URL = 'https://img.example.com';
    const IMAGE_URL = 'abc/yozhik.jpg';

    /** @test */
    public function it_checks_securityKey_and_baseUrl_parameters()
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl(self::IMAGE_URL);
        $this->assertEquals('unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->baseUrl(self::BASE_URL);
        $this->assertEquals(self::BASE_URL . '/unsafe/' . self::IMAGE_URL, $thumbor->get());

        $thumbor->securityKey(self::SECURITY_KEY);
        $this->assertEquals(self::BASE_URL . '/nXc3J50ZiEUqePyYLW4yJq8d1mc=/' . self::IMAGE_URL, $thumbor->get());
    }

    /** @test */
    public function it_checks_final_get()
    {
        $thumbor = new Thumbor();

        $thumbor->imageUrl(self::IMAGE_URL);
        $this->assertEquals('unsafe/' . self::IMAGE_URL, $thumbor->get());

        $this->assertEquals('unsafe/123/' . self::IMAGE_URL, $thumbor->get('123/' . self::IMAGE_URL));
    }

    /** @test */
    public function it_checks_final_get_exception()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        $this->assertEquals('unsafe/' . self::IMAGE_URL, $thumbor->get());
    }
}
