<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class TrimTest extends TestCase
{
    public function testItChecksIfTrimIsWorkingCorrectly(): void
    {
        $result = (new Thumbor())->trim()->get('abc.jpg');
        self::assertSame('unsafe/trim/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::TOP_LEFT)->get('abc.jpg');
        self::assertSame('unsafe/trim:top-left/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->get('abc.jpg');
        self::assertSame('unsafe/trim:bottom-right:200/abc.jpg', $result);

        $result = (new Thumbor())->trim(Trim::BOTTOM_RIGHT, 200)->noTrim()->get('abc.jpg');
        self::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfTrimIsThrowingExceptionAboutColorSource(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/colorSource/');
        (new Thumbor())->trim('asd')->get('abc.jpg');
    }

    public function testItChecksIfTrimIsThrowingExceptionAboutTolerance(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/tolerance/');
        (new Thumbor())->trim(Trim::TOP_LEFT, 500)->get('abc.jpg');
    }
}
