<?php declare(strict_types=1);

namespace Beeyev\Thumbor\Manipulations;

/**
 * Smart Crop.
 *
 * @see \Beeyev\Thumbor\Thumbor::smartCropEnable()
 */
class SmartCrop
{

    protected bool $isSmartCropEnabled = false;

    public function smartCropEnable(): SmartCrop
    {
        $this->isSmartCropEnabled = true;

        return $this;
    }

    public function smartCropDisable(): SmartCrop
    {
        $this->isSmartCropEnabled = false;

        return $this;
    }

    public function getSmartCrop(): ?string
    {
        return $this->isSmartCropEnabled ? 'smart' : null;
    }

}
