<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Test\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ValignTest extends TestCase
{
    public function testItChecksIfValignIsWorkingCorrectly()
    {
        $result = (new Thumbor())->Valign(Valign::TOP)->get('abc.jpg');
        static::assertSame('unsafe/top/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::MIDDLE)->get('abc.jpg');
        static::assertSame('unsafe/middle/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->get('abc.jpg');
        static::assertSame('unsafe/bottom/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->noValign()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfValignIsThrowingException()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/Incorrect value/');
        (new Thumbor())->Valign('abc')->get('abc.jpg');
    }
}
