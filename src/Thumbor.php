<?php

declare(strict_types=1);

namespace Beeyev\Thumbor;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Support\Security;
use Beeyev\Thumbor\Support\Validator;

class Thumbor
{
    /** @var string|null */
    protected $baseUrl;

    /** @var string|null */
    protected $securityKey;

    /** @var string|null */
    protected $sourceImageUrl;

    /** @var string|null */
    protected $trim;
    /** @var string|null */
    protected $crop;
    /** @var string|null */
    protected $resizeOrFit;

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
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
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

    public function imageUrl(string $sourceImageUrl): self
    {
        $this->sourceImageUrl = ltrim($sourceImageUrl, '/');

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->sourceImageUrl;
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
     * @param Trim::TOP_LEFT|Trim::BOTTOM_RIGHT $colorSource Possible values are Trim::TOP_LEFT, Trim::BOTTOM_RIGHT
     * @param int<Trim::TOLEARNCE_MIN, Trim::TOLEARNCE_MAX>|null $tolerance range between Trim::TOLEARNCE_MIN - Trim::TOLEARNCE_MAX
     *
     * @throws ThumborInvalidArgumentException
     */
    public function trim(string $colorSource = null, int $tolerance = null): self
    {
        if ($colorSource !== null && (!in_array($colorSource, [Trim::TOP_LEFT, Trim::BOTTOM_RIGHT], true))) {
            throw new ThumborInvalidArgumentException('Incorrect value `$colorSource` provided, given value is: ' . $colorSource);
        }
        /* @phpstan-ignore-next-line */
        if ($tolerance !== null && ($tolerance < Trim::TOLEARNCE_MIN || $tolerance > Trim::TOLEARNCE_MAX)) {
            throw new ThumborInvalidArgumentException('`$tolerance` value should be between ' . Trim::TOLEARNCE_MIN . ' and ' . Trim::TOLEARNCE_MAX . ', given value is: ' . $tolerance);
        }
        $this->trim = implode(':', array_filter(['trim', $colorSource, $tolerance]));

        return $this;
    }

    /**
     * Removes trim parameters.
     */
    public function noTrim(): self
    {
        $this->trim = null;

        return $this;
    }

    /**
     * Crop.
     *
     * Manually specify crop window.
     * $topLeftX & $topLeftY - Define the first point is the left-top point of the cropping rectangle.
     * $bottomRightX & $bottomRightY - Define the second point is the right-bottom point.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#manual-crop
     *
     * @param int<0, max> $topLeftX
     * @param int<0, max> $topLeftY
     * @param int<0, max> $bottomRightX
     * @param int<0, max> $bottomRightY
     */
    public function crop(int $topLeftX, int $topLeftY, int $bottomRightX, int $bottomRightY): self
    {
        if (min([$topLeftX, $topLeftY, $bottomRightX, $bottomRightY]) < 0) {
            throw new ThumborInvalidArgumentException("One or more of the provided integer values are negative! Provided values: topLeftX - `{$topLeftX}`, topLeftY - `{$topLeftY}`, bottomRightX - `{$bottomRightX}`, bottomRightY - `{$bottomRightY}`");
        }
        $this->crop = "{$topLeftX}x{$topLeftY}:{$bottomRightX}x{$bottomRightY}";

        return $this;
    }

    /**
     * Removes crop parameters.
     */
    public function noCrop(): self
    {
        $this->crop = null;

        return $this;
    }

    /**
     * Resize / Fit
     *
     * Resize the image to the specified dimensions.
     *
     * Use a value of 0 for proportional resizing. E.g. for a 640 x 480 image,
     * `->resize(320, 0)` or `->resize(320)` omitting one of the values or using zero will resize proportional to the original image
     * `->resize(-320, -10)` minus signs mean flip horizontally and vertically;
     * Use a value of `Resize::ORIG` to use an original image dimension. E.g. for a 640
     * x 480 image, `->resize(320, Resize::ORIG)` yields a 320 x 480 thumbnail
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html?highlight=fit-in#image-size
     *
     *  The `$fit` argument specifies that the image should not be auto-cropped and auto-resized to be EXACTLY the specified size, and should be fit in an imaginary box of width and height, instead.
     * `->resize(320, 220, Fit::FIT_IN)`
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#fit-in
     *
     * @param Resize::ORIG|int|null $width Possible values are Resize::ORIG, positive or negative integer, null
     * @param Resize::ORIG|int|null $height Possible values are Resize::ORIG, positive or negative integer, null
     * @param Fit::*|null $fit Possible values are Fit::FIT_IN, Fit::FULL_FIT_IN, Fit::ADAPTIVE_FIT_IN, Fit::ADAPTIVE_FULL_FIT_IN
     */
    public function resizeOrFit($width = null, $height = null, string $fit = null): Thumbor
    {
        $validatedValues = [$width, $height];
        if (implode($validatedValues) === '') {
            throw new ThumborInvalidArgumentException('At least one value `$width` or `$height` should be defined!');
        }

        array_map(static function ($value) {
            if ($value !== null && !is_int($value) && $value !== Resize::ORIG) {
                throw new ThumborInvalidArgumentException('On of the arguments provided contains incorrect value! Given value: ' . $value);
            }
        }, $validatedValues);

        if ($fit !== null && (!in_array($fit, [Fit::FIT_IN, Fit::FULL_FIT_IN, Fit::ADAPTIVE_FIT_IN, Fit::ADAPTIVE_FULL_FIT_IN], true))) {
            throw new ThumborInvalidArgumentException('Incorrect value `$fit` provided, given value is: ' . $fit);
        }

        $this->resizeOrFit = ($fit ? "{$fit}/" : '') . implode('x', [$width, $height]);

        return $this;
    }

    /**
     * Removes ResizeOrFit parameters.
     */
    public function noResizeOrFit(): self
    {
        $this->resizeOrFit = null;

        return $this;
    }

    /**
     * Returns ready to use URL.
     *
     * @throws ThumborException
     *
     * @return string
     */
    public function get(string $sourceImageUrl = null)
    {
        if ($sourceImageUrl !== null) {
            $this->imageUrl($sourceImageUrl);
        }

        return $this->buildUrl();
    }

    /**
     * Builds the resulting url.
     */
    protected function buildUrl(): string
    {
        if (!$this->getImageUrl()) {
            throw new ThumborException('Source image URL was not set.');
        }
        $manipulations = [
            $this->trim,
            $this->crop,
            $this->resizeOrFit,
        ];

        $manipulations = array_filter($manipulations, static function ($var) {return $var !== null; });
        $manipulations = implode('/', $manipulations);

        $urlWithoutBase = implode('/', array_filter([$manipulations, $this->getImageUrl()]));

        $signature = $this->getSecurityKey() ? Security::sign($this->getSecurityKey(), $urlWithoutBase) : 'unsafe';

        return implode('/', array_filter([$this->getBaseUrl(), $signature, $urlWithoutBase]));
    }

//    public function abc()
//    {
//        $this->trim('top-left', 200);
//    }
}
