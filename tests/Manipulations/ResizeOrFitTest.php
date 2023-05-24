<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResizeOrFitTest extends TestCase
{
    public function testItChecksIfResizeOrFitIsWorkingCorrectly()
    {
        $result = (new Thumbor())->resizeOrFit(100)->get('abc.jpg');
        static::assertSame('unsafe/100x/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(null, 200)->get('abc.jpg');
        static::assertSame('unsafe/x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200)->get('abc.jpg');
        static::assertSame('unsafe/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::FIT_IN)->get('abc.jpg');
        static::assertSame('unsafe/fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::FULL_FIT_IN)->get('abc.jpg');
        static::assertSame('unsafe/full-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FIT_IN)->get('abc.jpg');
        static::assertSame('unsafe/adaptive-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FULL_FIT_IN)->get('abc.jpg');
        static::assertSame('unsafe/adaptive-full-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FULL_FIT_IN)->noResizeOrFit()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfResizeOrFitIsThrowingExceptionWhenBothArgumentsNull()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/At least one value/');
        (new Thumbor())->resizeOrFit()->get('abc.jpg');
    }

    public function testItChecksIfResizeOrFitIsThrowingExceptionWhenOneArgumentIsIncorrect()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/One of provided arguments contain incorrect value/');
        (new Thumbor())->resizeOrFit('abc')->get('abc.jpg');
    }

    public function testItChecksIfResizeOrFitIsThrowingExceptionWhenFitParameterIsIncorrect()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Incorrect value/');
        (new Thumbor())->resizeOrFit(100, 200, 'abc')->get('abc.jpg');
    }
}
