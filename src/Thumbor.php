<?php

declare(strict_types=1);

namespace Beeyev\Thumbor;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Support\Validator;

class Thumbor
{
    /** @var string|null */
    protected $baseUrl;

    /** @var string|null */
    protected $securityKey;

    public function __construct(string $baseUrl = null, string $securityKey = null)
    {
        $this->baseUrl($baseUrl);
        $this->securityKey($securityKey);
    }

    /**
     * @param string|null $baseUrl
     *
     * @throws ThumborInvalidArgumentException
     */
    public function baseUrl($baseUrl): self
    {
        if (Validator::canBeString($baseUrl) === false) {
            throw new ThumborInvalidArgumentException('Provided value for `$baseUrl` can not be automatically casted to string!');
        }
        $this->baseUrl = $baseUrl === null ? null : rtrim($baseUrl, '/');

        return $this;
    }

    /**
     * @param string|null $securityKey
     *
     * @throws ThumborInvalidArgumentException
     */
    public function securityKey($securityKey): self
    {
        if (Validator::canBeString($securityKey) === false) {
            throw new ThumborInvalidArgumentException('Provided value for `$securityKey` can not be automatically casted to string!');
        }
        $this->securityKey = $securityKey === null ? null : (string) $securityKey;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecurityKey()
    {
        return $this->securityKey;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
