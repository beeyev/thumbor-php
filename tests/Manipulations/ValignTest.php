<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class ValignTest extends TestCase
{
    /** @test */
    public function it_checks_if_Valign_is_working_correctly()
    {
        $result = (new Thumbor())->Valign(Valign::TOP)->get('abc.jpg');
        $this->assertEquals('unsafe/top/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::MIDDLE)->get('abc.jpg');
        $this->assertEquals('unsafe/middle/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->get('abc.jpg');
        $this->assertEquals('unsafe/bottom/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->noValign()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }

    /** @test */
    public function it_checks_if_Valign_is_throwing_exception()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Incorrect value/');
        (new Thumbor())->Valign('abc')->get('abc.jpg');
    }
}
