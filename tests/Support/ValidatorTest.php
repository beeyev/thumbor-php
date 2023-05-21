<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Support;

use Beeyev\Thumbor\Support\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /** @test */
    public function it_checks_correct_values_for_canBeString()
    {
        $stringable = new class() {
            public function __toString(): string
            {
                return 'test';
            }
        };
        $this->assertTrue(Validator::canBeString(123));
        $this->assertTrue(Validator::canBeString('abc'));
        $this->assertTrue(Validator::canBeString(null));
        $this->assertTrue(Validator::canBeString($stringable));
        $this->assertFalse(Validator::canBeString(new \stdClass()));
        $this->assertFalse(Validator::canBeString([123]));
    }
}
