<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Exceptions\ThumborInvalidArgumentException;
use Beeyev\Thumbor\Manipulations\Filter;
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Support\Security;

class Thumbor
{
    /** @var string|null */
    protected $baseUrl;

    /** @var string|null */
    protected $securityKey;

    /** @var string|null */
    protected $sourceImageUrl;
    /** @var string|null */
    protected $metadataOnly;
    /** @var string|null */
    protected $trim;
    /** @var string|null */
    protected $crop;
    /** @var string|null */
    protected $resizeOrFit;
    /** @var string|null */
    protected $halign;
    /** @var string|null */
    protected $valign;
    /** @var string|null */
    protected $smartCrop;
    /** @var string|null */
    protected $filter;
    /** @var array<string, string> */
    protected $filtersCollection = [];

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
        /* @phpstan-ignore-next-line */
        if ($baseUrl !== null && !is_string($baseUrl)) {
            throw new ThumborInvalidArgumentException('Provided value for `$baseUrl` is not a string or NULL!');
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
     * @param int|string|null $securityKey
     *
     * @throws ThumborInvalidArgumentException
     */
    public function securityKey($securityKey): self
    {
        /* @phpstan-ignore-next-line */
        if ($securityKey !== null && !is_string($securityKey) && !is_int($securityKey)) {
            throw new ThumborInvalidArgumentException('Provided value for `$securityKey` is not a string, integer or NULL!');
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
     * Metadata
     *
     * Specify that JSON metadata should be returned instead of the image.
     */
    public function metadataOnly(): self
    {
        $this->metadataOnly = 'meta';

        return $this;
    }

    /**
     * Removes Metadata.
     */
    public function noMetadataOnly(): self
    {
        $this->metadataOnly = null;

        return $this;
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
     * @param Trim::BOTTOM_RIGHT|Trim::TOP_LEFT                  $colorSource Possible values are Trim::TOP_LEFT, Trim::BOTTOM_RIGHT
     * @param int<Trim::TOLEARNCE_MIN, Trim::TOLEARNCE_MAX>|null $tolerance   range between Trim::TOLEARNCE_MIN - Trim::TOLEARNCE_MAX
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
        /* @phpstan-ignore-next-line */
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
     * @param int|Resize::ORIG|null $width  Possible values are Resize::ORIG, positive or negative integer, null
     * @param int|Resize::ORIG|null $height Possible values are Resize::ORIG, positive or negative integer, null
     * @param Fit::*|null           $fit    Possible values are Fit::FIT_IN, Fit::FULL_FIT_IN, Fit::ADAPTIVE_FIT_IN, Fit::ADAPTIVE_FULL_FIT_IN
     */
    public function resizeOrFit($width = null, $height = null, string $fit = null): self
    {
        $validatedValues = [$width, $height];
        if (implode('', $validatedValues) === '') {
            throw new ThumborInvalidArgumentException('At least one value `$width` or `$height` should be defined!');
        }

        array_map(static function ($value) {
            /* @phpstan-ignore-next-line */
            if ($value !== null && !is_int($value) && $value !== Resize::ORIG) {
                throw new ThumborInvalidArgumentException('One of provided arguments contain incorrect value! Given value: ' . $value);
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
     * Horizontal Align
     * Specify horizontal alignment used if width is altered due to cropping.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#horizontal-align
     *
     * @param Halign::* $halign possible values are Halign::LEFT, Halign::CENTER, Halign::RIGHT
     */
    public function halign(string $halign): self
    {
        if (!in_array($halign, [Halign::LEFT, Halign::CENTER, Halign::RIGHT], true)) {
            throw new ThumborInvalidArgumentException('Incorrect value `$halign` provided, given value is: ' . $halign);
        }
        $this->halign = $halign;

        return $this;
    }

    /**
     * Removes Horizontal Align.
     */
    public function noHalign(): self
    {
        $this->halign = null;

        return $this;
    }

    /**
     * Vertical Align
     * Specify vertical alignment used if height is altered due to cropping.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#vertical-align
     *
     * @param Valign::* $valign possible values are Valign::TOP, Valign::MIDDLE, Valign::BOTTOM
     */
    public function valign(string $valign): self
    {
        if (!in_array($valign, [Valign::TOP, Valign::MIDDLE, Valign::BOTTOM], true)) {
            throw new ThumborInvalidArgumentException('Incorrect value `$halign` provided, given value is: ' . $valign);
        }
        $this->valign = $valign;

        return $this;
    }

    /**
     * Removes Vertical Align.
     */
    public function noValign(): self
    {
        $this->valign = null;

        return $this;
    }

    /**
     * Smart Crop.
     *
     * Enables cropping (overrides halign/valign).
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#smart-cropping
     */
    public function smartCrop(): self
    {
        $this->smartCrop = 'smart';

        return $this;
    }

    /**
     * Removes Smart Crop.
     */
    public function noSmartCrop(): self
    {
        $this->smartCrop = null;

        return $this;
    }

    /**
     * Filters
     *
     * Add a filter, e.g. `->addFilter(Filter::ROUND_CORNER, '20%7C20',0,0,0)->addFilter('cover')->addFilter('blur', 7)`.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#filters
     * @see https://thumbor.readthedocs.io/en/latest/filters.html
     *
     * @param Filter::*|int|string|null ...$args
     */
    public function addFilter(string $filterName, ...$args): self
    {
        array_map(static function ($value) {
            /* @phpstan-ignore-next-line */
            if ($value !== null && !is_int($value) && !is_string($value)) {
                throw new ThumborInvalidArgumentException('One of provided arguments contain incorrect value! Given value: ' . $value);
            }
        }, $args);

        $this->filtersCollection[$filterName] = sprintf('%s(%s)', $filterName, implode(',', $args));

        $this->filter = 'filters:' . implode(':', $this->filtersCollection);

        return $this;
    }

    /**
     * Removes all filters.
     */
    public function noFilter(): self
    {
        $this->filter = null;
        $this->filtersCollection = [];

        return $this;
    }

    /**
     * Returns ready to use URL.
     *
     * @throws ThumborException
     */
    public function get(string $sourceImageUrl = null): string
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
            $this->metadataOnly,
            $this->trim,
            $this->crop,
            $this->resizeOrFit,
            $this->halign,
            $this->valign,
            $this->smartCrop,
            $this->filter,
        ];

        $manipulations = array_filter($manipulations, static function ($var) {
            return $var !== null;
        });
        $manipulations = implode('/', $manipulations);

        $urlWithoutBase = implode('/', array_filter([$manipulations, $this->getImageUrl()]));

        $signature = $this->getSecurityKey() ? Security::sign($this->getSecurityKey(), $urlWithoutBase) : 'unsafe';

        return implode('/', array_filter([$this->getBaseUrl(), $signature, $urlWithoutBase]));
    }
}
