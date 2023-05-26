<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Test\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class HalignTest extends TestCase
{
    public function testItChecksIfHalignIsWorkingCorrectly()
    {
        $result = (new Thumbor())->halign(Halign::LEFT)->get('abc.jpg');
        static::assertSame('unsafe/left/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::CENTER)->get('abc.jpg');
        static::assertSame('unsafe/center/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->get('abc.jpg');
        static::assertSame('unsafe/right/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->noHalign()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfHalignIsThrowingException()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/Incorrect value/');
        (new Thumbor())->halign('abc')->get('abc.jpg');
    }
}
