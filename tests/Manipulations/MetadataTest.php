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
 *
 * @coversNothing
 */
final class MetadataTest extends TestCase
{
    public function testItChecksIfMetadataIsWorkingCorrectly(): void
    {
        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->metadataOnly();
        self::assertSame('unsafe/meta/abc.jpg', $thumbor->get());

        $thumbor->noMetadataOnly();
        self::assertSame('unsafe/abc.jpg', $thumbor->get());
    }
}
