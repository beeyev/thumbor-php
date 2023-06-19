<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Tests\TestCase;

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
