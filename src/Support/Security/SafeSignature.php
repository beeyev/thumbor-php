<?php

declare(strict_types=1);

namespace Beeyev\Thumbor\Support\Security;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;

/**
 * Class for
 *
 * @see https://thumbor.readthedocs.io/en/latest/security.html
 */
class SafeSignature implements SecurityInterface
{
    public function __construct(
        /**
         * The security key.
         *
         * @var non-empty-string
         */
        private readonly string $securityKey,
    ) {
        if ($this->securityKey === '') {
            throw new ThumborInvalidArgumentException('The security key cannot be empty.');
        }
    }

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
        if ($urlWithoutBase === '') {
            throw new ThumborInvalidArgumentException('The URL cannot be empty.');
        }

        return strtr(
            base64_encode(hash_hmac('sha1', $urlWithoutBase, $this->securityKey, true)),
            '/+',
            '_-',
        );
    }
}
