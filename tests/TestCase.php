<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function expectExceptionMessageMatchesCase(string $regularExpression)
    {
        if (version_compare(\PHPUnit\Runner\Version::id(), '8.0.0', '>=')) {
            $this->expectExceptionMessageMatches($regularExpression);
        } else {
            $this->expectExceptionMessageRegExp($regularExpression);
        }
    }
}
