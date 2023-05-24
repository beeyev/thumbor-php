<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class MetadataTest extends TestCase
{
    public function testItChecksIfMetadataIsWorkingCorrectly()
    {
        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->metadataOnly();
        static::assertSame('unsafe/meta/abc.jpg', $thumbor->get());

        $thumbor->noMetadataOnly();
        static::assertSame('unsafe/abc.jpg', $thumbor->get());
    }
}
