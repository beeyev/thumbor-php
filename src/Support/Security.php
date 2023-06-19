<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Support;

class Security
{
    /**
     * Signs the given url.
     */
    public static function sign(string $securityKey, string $urlWithoutBase): string
    {
        return strtr(
            base64_encode(hash_hmac('sha1', $urlWithoutBase, $securityKey, true)),
            '/+',
            '_-'
        );
    }
}
