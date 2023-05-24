<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class CropTest extends TestCase
{
    /** @test */
    public function it_checks_if_crop_is_working_correctly()
    {
        $result = (new Thumbor())->crop(100, 200, 55, 44)->get('abc.jpg');
        $this->assertEquals('unsafe/100x200:55x44/abc.jpg', $result);

        $result = (new Thumbor())->crop(100, 200, 55, 44)->noCrop()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }

    /** @test */
    public function it_checks_if_crop_is_throwing_exception()
    {
        $this->expectException(ThumborInvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/One or more of the provided integer values are negative/');
        (new Thumbor())->crop(-1, 200, 55, 44)->get('abc.jpg');
    }
}
