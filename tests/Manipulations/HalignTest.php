<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class HalignTest extends TestCase
{
    /** @test */
    public function it_checks_if_halign_is_working_correctly()
    {
        $result = (new Thumbor())->halign(Halign::LEFT)->get('abc.jpg');
        $this->assertEquals('unsafe/left/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::CENTER)->get('abc.jpg');
        $this->assertEquals('unsafe/center/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->get('abc.jpg');
        $this->assertEquals('unsafe/right/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->noHalign()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }

    /** @test */
    public function it_checks_if_halign_is_throwing_exception()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Incorrect value/');
        (new Thumbor())->halign('abc')->get('abc.jpg');
    }
}
