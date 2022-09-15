<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Contracts\CourierMakeShipment;
use Sylapi\Courier\Contracts\Shipment;

class EcontCourierMakeShipment implements CourierMakeShipment
{
    public function makeShipment(): Shipment
    {
        return new EcontShipment();
    }
}
