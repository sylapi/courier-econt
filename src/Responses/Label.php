<?php

namespace Sylapi\Courier\Econt\Responses;

use Sylapi\Courier\Responses\Label as LabelResponse;

class Label extends LabelResponse
{

    const DEFAULT_LABEL_TYPE = 'A4';

    private string $labelType = self::DEFAULT_LABEL_TYPE;

    public function getLabelType(): string
    {
        return $this->labelType;
    }

    public function setLabelType(string $labelType): self
    {
        $this->labelType = $labelType;

        return $this;
    }

}
