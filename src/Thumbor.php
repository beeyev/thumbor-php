<?php

declare(strict_types=1);

namespace Beeyev\Thumbor;

use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Trim;
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

    /**
     * Trim.
     *
     * Removing surrounding space in images can be done using the trim option.
     * Trim surrounding space from the thumbnail. The top-left corner of the
     * image is assumed to contain the background colour. To specify otherwise,
     * pass either 'top-left' or 'bottom-right' as the $colourSource argument.
     * For tolerance the euclidean distance between the colors of the reference pixel
     * and the surrounding pixels is used. If the distance is within the
     * tolerance they'll get trimmed. For an RGB image the tolerance would
     * be within the range 0-442.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#trim
     *
     * @param Trim::*|null $colorSource Possible values are Trim::TOP_LEFT, Trim::BOTTOM_RIGHT
     * @param int<0, 422>|null $tolerance range between 0-442
     *
     * @return $this
     */
    public function trim(string $colorSource = null, int $tolerance = null): self
    {
    }
}
