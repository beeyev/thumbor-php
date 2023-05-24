<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class ThumborTest extends TestCase
{
    /** @test */
    public function it_checks_if_baseUrl_accepts_string()
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl('http://seriouscat.com/');
        $this->assertEquals('http://seriouscat.com', $thumbor->getBaseUrl());
    }

    /** @test */
    public function it_checks_if_baseUrl_accepts_null()
    {
        $thumbor = new Thumbor();
        $thumbor->baseUrl(null);
        $this->assertEquals(null, $thumbor->getBaseUrl());
    }

    /** @test */
    public function it_checks_if_baseUrl_throws_exception()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/is not a string or NULL/');
        $thumbor->baseUrl(new \stdClass());
    }

    /** @test */
    public function it_checks_if_securityKey_accepts_string()
    {
        $securityKey = '31337';
        $thumbor = new Thumbor();
        $thumbor->securityKey($securityKey);
        $this->assertEquals($securityKey, $thumbor->getSecurityKey());
    }

    /** @test */
    public function it_checks_if_securityKey_accepts_null()
    {
        $thumbor = new Thumbor();
        $thumbor->securityKey(null);
        $this->assertEquals(null, $thumbor->getSecurityKey());
    }

    /** @test */
    public function it_checks_if_securityKey_throws_exception()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/string, integer or NULL/');
        $thumbor->securityKey(new \stdClass());
    }

    /** @test */
    public function it_checks_if_imageUrl_is_set()
    {
        $thumbor = new Thumbor();
        $thumbor->imageUrl('/yozhik.jpg');
        $this->assertEquals('yozhik.jpg', $thumbor->getImageUrl());
    }

    public function it_checks_if_exception_is_thrown_when_imageUrl_is_not_set()
    {
        $thumbor = new Thumbor();
        $this->expectException(ThumborException::class);
        $this->expectExceptionMessage('Source image URL was not set.');
        $thumbor->get();
    }
}
