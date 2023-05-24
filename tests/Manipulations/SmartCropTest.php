<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SmartCropTest extends TestCase
{
    public function testItChecksIfSmartCropIsWorkingCorrectly()
    {
        $result = (new Thumbor())->smartCrop()->get('abc.jpg');
        static::assertSame('unsafe/smart/abc.jpg', $result);

        $result = (new Thumbor())->smartCrop()->noSmartCrop()->get('abc.jpg');
        static::assertSame('unsafe/abc.jpg', $result);
    }
}
