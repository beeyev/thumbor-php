<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Test\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class TrimTest extends TestCase
{
    public function testItChecksIfTrimIsWorkingCorrectly()
    {
        $result = (new Thumbor())->trim()->get('abc.jpg');
        static::assertSame('unsafe/trim/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::TOP_LEFT)->get('abc.jpg');
        static::assertSame('unsafe/trim:top-left/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->get('abc.jpg');
        static::assertSame('unsafe/trim:bottom-right:200/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->noTrim()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfTrimIsThrowingExceptionAboutColorSource()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/colorSource/');
        (new Thumbor())->trim('asd')->get('abc.jpg');
    }

    public function testItChecksIfTrimIsThrowingExceptionAboutTolerance()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/tolerance/');
        (new Thumbor())->trim(Trim::TOP_LEFT, 500)->get('abc.jpg');
    }
}
