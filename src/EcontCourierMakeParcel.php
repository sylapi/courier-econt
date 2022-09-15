<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Contracts\CourierMakeParcel;
use Sylapi\Courier\Contracts\Parcel;

class EcontCourierMakeParcel implements CourierMakeParcel
{
    public function makeParcel(): Parcel
    {
        return new EcontParcel();
    }
}
