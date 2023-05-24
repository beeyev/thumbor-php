<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class CombinedTest extends TestCase
{
    /** @test */
    public function it_checks_if_url_builder_works_correctly()
    {
        $expected = 'https://img.example.com/4s1z_Yu1tYN2aQ-VZTg-mU0tMKg=/meta/trim:top-left:55/12x23:24x25/fit-in/11x33/right/bottom/smart/filters:strip_icc():blur(1,abc)/ezhik.jpg';
        $result = (new Thumbor('https://img.example.com/', '31337'))
            ->metadataOnly()
            ->trim(Trim::TOP_LEFT, 55)
            ->crop(12, 23, 24, 25)
            ->resizeOrFit(11, 33, Fit::FIT_IN)
            ->halign(Halign::RIGHT)
            ->valign(Valign::BOTTOM)
            ->smartCrop()
            ->addFilter('strip_icc')
            ->addFilter('blur', 1, 'abc')
            ->imageUrl('ezhik.jpg')
            ->get();
        $this->assertEquals($expected, $result);
    }
}
