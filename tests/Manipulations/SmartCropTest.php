<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class SmartCropTest extends TestCase
{
    /** @test */
    public function it_checks_if_SmartCrop_is_working_correctly()
    {
        $result = (new Thumbor())->smartCrop()->get('abc.jpg');
        $this->assertEquals('unsafe/smart/abc.jpg', $result);

        $result = (new Thumbor())->smartCrop()->noSmartCrop()->get('abc.jpg');
        $this->assertEquals('unsafe/abc.jpg', $result);
    }
}
