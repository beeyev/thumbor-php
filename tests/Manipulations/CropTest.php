<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Test\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CropTest extends TestCase
{
    public function testItChecksIfCropIsWorkingCorrectly()
    {
        $result = (new Thumbor())->crop(100, 200, 55, 44)->get('abc.jpg');
        static::assertSame('unsafe/100x200:55x44/abc.jpg', $result);

        $result = (new Thumbor())->crop(100, 200, 55, 44)->noCrop()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }

    public function testItChecksIfCropIsThrowingException()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatchesCase('/One or more of the provided integer values are negative/');
        (new Thumbor())->crop(-1, 200, 55, 44)->get('abc.jpg');
    }
}
