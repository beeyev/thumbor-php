<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Test\Manipulations;

use Beeyev\Thumbor\Thumbor;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
    /** @test */
    public function it_checks_if_Metadata_is_working_correctly()
    {
        $thumbor = (new Thumbor())->imageUrl('abc.jpg')->metadataOnly();
        $this->assertEquals('unsafe/meta/abc.jpg', $thumbor->get());

        $thumbor->noMetadataOnly();
        $this->assertEquals('unsafe/abc.jpg', $thumbor->get());
    }
}
