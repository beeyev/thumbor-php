<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class ResizeOrFitTest extends TestCase
{
    /** @test */
    public function it_checks_if_ResizeOrFit_is_working_correctly()
    {
        $result = (new Thumbor())->resizeOrFit(100)->get('abc.jpg');
        $this->assertEquals('unsafe/100x/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(null, 200)->get('abc.jpg');
        $this->assertEquals('unsafe/x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200)->get('abc.jpg');
        $this->assertEquals('unsafe/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::FIT_IN)->get('abc.jpg');
        $this->assertEquals('unsafe/fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::FULL_FIT_IN)->get('abc.jpg');
        $this->assertEquals('unsafe/full-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FIT_IN)->get('abc.jpg');
        $this->assertEquals('unsafe/adaptive-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FULL_FIT_IN)->get('abc.jpg');
        $this->assertEquals('unsafe/adaptive-full-fit-in/100x200/abc.jpg', $result);

        $result = (new Thumbor())->resizeOrFit(100, 200, Fit::ADAPTIVE_FULL_FIT_IN)->noResizeOrFit()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }

    /** @test */
    public function it_checks_if_ResizeOrFit_is_throwing_exception_when_both_arguments_null()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/At least one value/');
        (new Thumbor())->resizeOrFit()->get('abc.jpg');
    }

    /** @test */
    public function it_checks_if_ResizeOrFit_is_throwing_exception_when_one_argument_is_incorrect()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/One of provided arguments contain incorrect value/');
        (new Thumbor())->resizeOrFit('abc')->get('abc.jpg');
    }

    /** @test */
    public function it_checks_if_ResizeOrFit_is_throwing_exception_when_Fit_parameter_is_incorrect()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Incorrect value/');
        (new Thumbor())->resizeOrFit(100, 200, 'abc')->get('abc.jpg');
    }
}
