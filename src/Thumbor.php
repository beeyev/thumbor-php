<?php declare(strict_types=1);

namespace Beeyev\Thumbor;

use Beeyev\Thumbor\Exceptions\ThumborException;
use Beeyev\Thumbor\Manipulations\Crop;
use Beeyev\Thumbor\Manipulations\Filters;
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\SmartCrop;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Manipulations\Valign;

class Thumbor
{
    protected ?string $baseUrl = null;
    protected ?string $securityKey = null;
    protected ?string $sourceImageUrl = null;
    protected Trim $trim;
    protected Crop $crop;
    protected Fit $fit;
    protected Resize $resize;
    protected Halign $halign;
    protected Valign $valign;
    protected SmartCrop $smartCrop;
    protected Filters $filters;

    public function __construct(?string $baseUrl = null, ?string $securityKey = null)
    {
        $this->baseUrl($baseUrl);
        $this->securityKey($securityKey);
        $this->loadDependencies();
    }

    protected function loadDependencies()
    {
        $this->trim = new Trim();
        $this->crop = new Crop();
        $this->resize = new Resize();
        $this->halign = new Halign();
        $this->valign = new Valign();
        $this->smartCrop = new SmartCrop();
        $this->filters = new Filters();
        $this->fit = new Fit();
    }

    public function baseUrl(?string $baseUrl): Thumbor
    {
        if ($baseUrl) {
            $this->baseUrl = rtrim($baseUrl, '/');
        }

        return $this;
    }

    public function securityKey(?string $securityKey): Thumbor
    {
        $this->securityKey = $securityKey;

        return $this;
    }

    public function getSecurityKey(): ?string
    {
        return $this->securityKey;
    }

    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function imageUrl(string $sourceImageUrl): Thumbor
    {
        $this->sourceImageUrl = ltrim($sourceImageUrl, '/');

        return $this;
    }

    public function getImageUrl(): string
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
     * @param string|null $colorSource Possible values are Trim::TOP_LEFT,  Trim::BOTTOM_RIGHT
     * @param int|null    $tolerance   range between 0-442
     *
     * @return $this
     */
    public function trim(?string $colorSource = null, ?int $tolerance = null): Thumbor
    {
        $this->trim = $this->trim->trim($colorSource, $tolerance);

        return $this;
    }

    /**
     * Removes trim parameters.
     *
     * @return $this
     */
    public function noTrim(): Thumbor
    {
        $this->trim = $this->trim->noTrim();

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
     * @return $this
     */
    public function crop(int $topLeftX, int $topLeftY, int $bottomRightX, int $bottomRightY): Thumbor
    {
        $this->crop = $this->crop->crop($topLeftX, $topLeftY, $bottomRightX, $bottomRightY);

        return $this;
    }

    /**
     * Removes crop parameters.
     *
     * @return $this
     */
    public function noCrop(): Thumbor
    {
        $this->crop = $this->crop->noCrop();

        return $this;
    }

    /**
     * Fit.
     *
     * Specifies that the image should not be auto-cropped and auto-resized to be EXACTLY the specified size.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#fit-in
     *
     * @param string $fit Possible values are Fit::FIT_IN, Fit::FULL_FIT_IN, Fit::ADAPTIVE_FIT_IN, Fit::ADAPTIVE_FULL_FIT_IN
     *
     * @return $this
     */
    public function fit(string $fit): Thumbor
    {
        $this->fit = $this->fit->fit($fit);

        return $this;
    }

    /**
     * Removes fit parameters.
     *
     * @return $this
     */
    public function noFit(): Thumbor
    {
        $this->fit = $this->fit->noFit();

        return $this;
    }

    /**
     * Size.
     *
     * Resize the image to the specified dimensions.
     *
     * Use a value of 0 for proportional resizing. E.g. for a 640 x 480 image,
     * `->resize(320, 0)` yields a 320 x 240 thumbnail.
     *
     * Use a value of 'orig' to use an original image dimension. E.g. for a 640
     * x 480 image, `->resize(320, Resize::ORIG)` yields a 320 x 480 thumbnail
     *
     * @return $this
     */
    public function resize($width = null, $height = null): Thumbor
    {
        $this->resize = $this->resize->resize($width, $height);

        return $this;
    }

    /**
     * Helper to set width.
     * Please read the documentation for `resize()` method.
     *
     * @return $this
     */
    public function resizeWidth($width): Thumbor
    {
        $this->resize($width);

        return $this;
    }

    /**
     * Helper to set height.
     * Please read the documentation for `resize()` method.
     *
     * @return $this
     */
    public function resizeHeight($height): Thumbor
    {
        $this->resize(null, $height);

        return $this;
    }

    /**
     * Removes resize parameters.
     *
     * @return $this
     */
    public function noResize(): Thumbor
    {
        $this->resize = $this->resize->noResize();

        return $this;
    }

    /**
     * Horizontal Align
     * Specify horizontal alignment used if width is altered due to cropping.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#horizontal-align
     *
     * @param string $halign possible values are Halign::LEFT, Halign::CENTER, Halign::RIGHT
     *
     * @return $this
     */
    public function halign(string $halign): Thumbor
    {
        $this->halign = $this->halign->halign($halign);

        return $this;
    }

    /**
     * Removes Halign parameters.
     *
     * @return $this
     */
    public function noHalign(): Thumbor
    {
        $this->halign = $this->halign->noHalign();

        return $this;
    }

    /**
     * Vertical Align
     * Specify vertical alignment used if height is altered due to cropping.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#vertical-align
     *
     * @param string $valign possible values are Valign::TOP, Valign::MIDDLE, Valign::BOTTOM
     *
     * @return $this
     */
    public function valign(string $valign): Thumbor
    {
        $this->valign = $this->valign->valign($valign);

        return $this;
    }

    /**
     * Removes Valign parameters.
     *
     * @return $this
     */
    public function noValign(): Thumbor
    {
        $this->valign = $this->valign->noValign();

        return $this;
    }

    /**
     * Crop.
     *
     * Enables cropping (overrides halign/valign).
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#smart-cropping
     *
     * @return $this
     */
    public function smartCropEnable(): Thumbor
    {
        $this->smartCrop = $this->smartCrop->smartCropEnable();

        return $this;
    }

    /**
     * Crop.
     *
     *  Disables cropping
     *
     * @return $this
     */
    public function smartCropDisable(): Thumbor
    {
        $this->smartCrop = $this->smartCrop->smartCropDisable();

        return $this;
    }

    /**
     * Append a filter, e.g. `->addFilter('brightness', 42)`.
     *
     * @see https://thumbor.readthedocs.io/en/latest/usage.html#filters
     *
     * @param mixed ...$args
     */
    public function addFilter(string $filterName, ...$args): Thumbor
    {
        $this->filters = $this->filters->addFilter($filterName, $args);

        return $this;
    }

    /**
     *  Disables all filters.
     *
     * @return $this
     */
    public function noFilters(): Thumbor
    {
        $this->filters = $this->filters->noFilters();

        return $this;
    }

    /**
     * Returns ready to use URL.
     *
     * @throws ThumborException
     *
     * @return string
     */
    public function get(?string $sourceImageUrl = null)
    {
        if ($sourceImageUrl) {
            $this->imageUrl($sourceImageUrl);
        }

        return $this->buildUrl();
    }

    /**
     * Builds the resulting url.
     *
     * @throws ThumborException
     */
    protected function buildUrl()
    {
        if (!$this->getImageUrl()) {
            throw new ThumborException('Source image URL has not been provided.');
        }
        $manipulations = [
            $this->trim->getTrim(),
            $this->crop->getCrop(),
            $this->fit->getFit(),
            $this->resize->getResize(),
            $this->halign->getHalign(),
            $this->valign->getValign(),
            $this->smartCrop->getSmartCrop(),
            $this->filters->getFilters(),
        ];

        $manipulations = array_filter($manipulations, static function($var) {return $var !== null; });
        $manipulations = implode('/', $manipulations);

        $urlWithoutBase = implode('/', array_filter([$manipulations, $this->getImageUrl()]));

        $signature = $this->getSecurityKey() ? $this->sign($urlWithoutBase) : 'unsafe';

        return implode('/', array_filter([$this->getBaseUrl(), $signature, $urlWithoutBase]));
    }

    /**
     * Signs the given url.
     *
     * @throws ThumborException
     */
    public function sign(string $urlWithoutBase): string
    {
        if (!$this->getSecurityKey()) {
            throw new ThumborException('Security key was not provided.');
        }
        $signature = hash_hmac('sha1', $urlWithoutBase, $this->getSecurityKey(), true);

        return strtr(
            base64_encode($signature),
            '/+',
            '_-'
        );
    }
}
