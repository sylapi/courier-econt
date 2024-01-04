<?php

namespace Sylapi\Courier\Econt\Responses;

use Sylapi\Courier\Responses\Parcel as ParcelResponse;

class Parcel extends ParcelResponse
{
    private string $courierRequestId;
    
    public function getCourierRequestId(): string
    {
        return $this->courierRequestId;
    }

    public function setCourierRequestId(string $courierRequestId): self
    {
        $this->courierRequestId = $courierRequestId;

        return $this;
    }
}
