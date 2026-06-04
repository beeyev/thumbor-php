<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class HalignTest extends TestCase
{
    public function testItChecksIfHalignIsWorkingCorrectly(): void
    {
        $result = (new Thumbor())->halign(Halign::LEFT)->get('abc.jpg');
        self::assertSame('unsafe/left/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::CENTER)->get('abc.jpg');
        self::assertSame('unsafe/center/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->get('abc.jpg');
        self::assertSame('unsafe/right/abc.jpg', $result);

        $result = (new Thumbor())->halign(Halign::RIGHT)->noHalign()->get('abc.jpg');
        self::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfHalignIsThrowingException(): void
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/Incorrect value/');
        (new Thumbor())->halign('abc')->get('abc.jpg');
    }
}
