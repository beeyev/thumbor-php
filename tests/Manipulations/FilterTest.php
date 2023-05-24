<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function it_checks_if_adding_filters_is_working_correctly()
    {
        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->addFilter('round_corner', '20%7C20', 0, 0, 0);
        $this->assertEquals('unsafe/filters:round_corner(20%7C20,0,0,0)/abc.jpg', $thumbor->get());

        $thumbor->addFilter('brightness', 5)->addFilter('blur', 7);
        $this->assertEquals('unsafe/filters:round_corner(20%7C20,0,0,0):brightness(5):blur(7)/abc.jpg', $thumbor->get());

        $thumbor->noFilter();
        $this->assertEquals('unsafe/abc.jpg', $thumbor->get());

        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->addFilter('noise', 40);
        $this->assertEquals('unsafe/filters:noise(40)/abc.jpg', $thumbor->get());
    }
}
