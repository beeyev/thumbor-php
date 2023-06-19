<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Fit.
 *
 * @see \Beeyev\Thumbor\Thumbor::addFilter()
 */
class Filter
{
    /**
     * Overrides `AUTO_PNG_TO_JPG` config variable.
     *
     * @see https://thumbor.readthedocs.io/en/latest/autojpg.html
     */
    const AUTO_JPG = 'autojpg';

    /**
     * Sets the background layer to the specified color.
     *
     * @see https://thumbor.readthedocs.io/en/latest/background_color.html
     */
    const BACKGROUND_COLOR = 'background_color';

    /**
     * Applies a gaussian blur to the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/blur.html
     */
    const BLUR = 'blur';

    /**
     * Increases or decreases the image brightness.
     *
     * @see https://thumbor.readthedocs.io/en/latest/brightness.html
     */
    const BRIGHTNESS = 'brightness';

    /**
     * Increases or decreases the image contrast.
     *
     * @see https://thumbor.readthedocs.io/en/latest/contrast.html
     */
    const CONTRAST = 'contrast';

    /**
     * Filter runs a convolution matrix (or kernel) on the image
     *
     * @see https://thumbor.readthedocs.io/en/latest/convolution.html
     */
    const CONVOLUTION = 'convolution';

    /**
     * Filter is used in GIFs to extract their first frame as the image to be used as cover.
     *
     * @see https://thumbor.readthedocs.io/en/latest/cover.html
     */
    const COVER = 'cover';

    /**
     * Equalizes the color distribution in the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/equalize.html
     */
    const EQUALIZE = 'equalize';

    /**
     * Extract focal points
     *
     * @see https://thumbor.readthedocs.io/en/latest/extract_focal_points.html
     */
    const EXTRACT_FOCAL = 'extract_focal';

    /**
     * Returns an image sized exactly as requested independently of its ratio.
     *
     * @see https://thumbor.readthedocs.io/en/latest/filling.html
     */
    const FILL = 'fill';

    /**
     * Adds a focal point, which is used in later transforms.
     *
     * @see https://thumbor.readthedocs.io/en/latest/focal.html
     */
    const FOCAL = 'focal';

    /**
     * Specifies the output format of the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/format.html
     */
    const FORMAT = 'format';

    /**
     * Changes the image to grayscale.
     *
     * @see https://thumbor.readthedocs.io/en/latest/grayscale.html
     */
    const GRAYSCALE = 'grayscale';

    /**
     * Automatically degrades the quality of the image until the image is under the specified amount of bytes.
     *
     * @see https://thumbor.readthedocs.io/en/latest/max_bytes.html
     */
    const MAX_BYTES = 'max_bytes';

    /**
     * Filter tells thumbor not to upscale your images.
     *
     * @see https://thumbor.readthedocs.io/en/latest/no_upscale.html
     */
    const NO_UPSCALE = 'no_upscale';

    /**
     * Adds noise to the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/noise.html
     */
    const NOISE = 'noise';

    /**
     * Applies the specified proportion to the image’s height and width when cropping.
     *
     * @see https://thumbor.readthedocs.io/en/latest/proportion.html
     */
    const PROPORTION = 'proportion';

    /**
     * Filter changes the overall quality of the JPEG image (does nothing for PNGs or GIFs).
     *
     * @see https://thumbor.readthedocs.io/en/latest/quality.html
     */
    const QUALITY = 'quality';

    /**
     * Red eye
     *
     * @see https://thumbor.readthedocs.io/en/latest/red_eye.html
     */
    const RED_EYE = 'red_eye';

    /**
     * Filter changes the amount of color in each of the three channels.
     *
     * @see https://thumbor.readthedocs.io/en/latest/rgb.html
     */
    const RGB = 'rgb';

    /**
     * Rotates the given image according to the angle value passed.
     *
     * @see https://thumbor.readthedocs.io/en/latest/rotate.html
     */
    const ROTATE = 'rotate';

    /**
     * Adds rounded corners to the image using the specified color as background.
     *
     * @see https://thumbor.readthedocs.io/en/latest/round_corners.html
     */
    const ROUND_CORNER = 'round_corner';

    /**
     * Increases or decreases the image saturation.
     *
     * @see https://thumbor.readthedocs.io/en/latest/saturation.html
     */
    const SATURATION = 'saturation';

    /**
     * Enhances apparent sharpness of the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/sharpen.html
     */
    const SHARPEN = 'sharpen';

    /**
     * Stretches the image until it fits the required width and height, instead of cropping the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/stretch.html
     */
    const STRETCH = 'stretch';

    /**
     * Removes any Exif information in the resulting image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/strip_exif.html
     */
    const STRIP_EXIF = 'strip_exif';

    /**
     * Removes any ICC information in the resulting image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/strip_icc.html
     */
    const STRIP_ICC = 'strip_icc';

    /**
     * Filter tells thumbor to upscale your images.
     *
     * @see https://thumbor.readthedocs.io/en/latest/upscale.html
     */
    const UPSCALE = 'upscale';

    /**
     * Filter adds a watermark to the image.
     *
     * @see https://thumbor.readthedocs.io/en/latest/watermark.html
     */
    const WATERMARK = 'watermark';
}
