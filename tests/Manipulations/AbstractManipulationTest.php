<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Tests\Manipulations;

use Beeyev\Thumbor\Manipulations\AbstractManipulation;
use Beeyev\Thumbor\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * @internal
 */
#[CoversClass(AbstractManipulation::class)]
final class AbstractManipulationTest extends AbstractTestCase
{
    public function testNewInstance(): void
    {
        self::assertInstanceOf(AbstractManipulationClassStub::class, AbstractManipulationClassStub::new());
    }
}
