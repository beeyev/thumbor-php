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
final class FilterTest extends TestCase
{
    public function testItChecksIfAddingFiltersIsWorkingCorrectly()
    {
        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->addFilter('round_corner', '20%7C20', 0, 0, 0);
        static::assertSame('unsafe/filters:round_corner(20%7C20,0,0,0)/abc.jpg', $thumbor->get());

        $thumbor->addFilter('brightness', 5)->addFilter('blur', 7)->addFilter('autojpg');
        static::assertSame('unsafe/filters:round_corner(20%7C20,0,0,0):brightness(5):blur(7):autojpg()/abc.jpg', $thumbor->get());

        $thumbor->noFilter();
        static::assertSame('unsafe/abc.jpg', $thumbor->get());

        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->addFilter('noise', 40);
        static::assertSame('unsafe/filters:noise(40)/abc.jpg', $thumbor->get());
    }
}
