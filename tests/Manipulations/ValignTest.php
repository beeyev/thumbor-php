<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ValignTest extends TestCase
{
    public function testItChecksIfValignIsWorkingCorrectly(): void
    {
        $result = (new Thumbor())->Valign(Valign::TOP)->get('abc.jpg');
        self::assertSame('unsafe/top/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::MIDDLE)->get('abc.jpg');
        self::assertSame('unsafe/middle/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->get('abc.jpg');
        self::assertSame('unsafe/bottom/abc.jpg', $result);

        $result = (new Thumbor())->Valign(Valign::BOTTOM)->noValign()->get('abc.jpg');
        self::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfValignIsThrowingException(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/Incorrect value/');
        (new Thumbor())->Valign('abc')->get('abc.jpg');
    }
}
