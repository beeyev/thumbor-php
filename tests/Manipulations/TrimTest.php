<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{
    /** @test */
    public function it_checks_if_trim_is_working_correctly()
    {
        $result = (new Thumbor())->trim()->get('abc.jpg');
        $this->assertEquals('unsafe/trim/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::TOP_LEFT)->get('abc.jpg');
        $this->assertEquals('unsafe/trim:top-left/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->get('abc.jpg');
        $this->assertEquals('unsafe/trim:bottom-right:200/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->noTrim()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }

    /** @test */
    public function it_checks_if_trim_is_throwing_exception_about_colorSource()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/colorSource/');
        (new Thumbor())->trim('asd')->get('abc.jpg');
    }

    /** @test */
    public function it_checks_if_trim_is_throwing_exception_about_tolerance()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/tolerance/');
        (new Thumbor())->trim(Trim::TOP_LEFT, 500)->get('abc.jpg');
    }
}
