<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\SignatureHandler;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;

/**
 * @see https://thumbor.readthedocs.io/en/latest/security.html
 */
class UnsafeSignatureHandler implements SignatureHandlerInterface
{
    private const UNSAFE = 'unsafe';

    /**
     * Sign the given URL.
     *
     * @param non-empty-string $urlWithoutBase
     *
     * @return non-empty-string
     *
     * @throws ThumborInvalidArgumentException if the URL is empty
     */
    public function sign(string $urlWithoutBase): string
    {
        return self::UNSAFE;
    }
}
