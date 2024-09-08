<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Support\Security;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;

interface SecurityInterface
{
    /**
     * Sign the given URL.
     *
     * @param non-empty-string $urlWithoutBase
     *
     * @return non-empty-string
     *
     * @throws ThumborInvalidArgumentException if the URL is empty
     */
    public function sign(string $urlWithoutBase): string;
}
