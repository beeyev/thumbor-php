<?php

/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use PHPUnit\Runner\Version;

abstract class TestCase extends BaseTestCase
{
    public function expectExceptionMessageMatchesCase(string $regularExpression): void
    {
        if (version_compare(Version::id(), '8.0.0', '>=')) {
            $this->expectExceptionMessageMatches($regularExpression);
        } else {
            $this->expectExceptionMessageRegExp($regularExpression);
        }
    }
}
