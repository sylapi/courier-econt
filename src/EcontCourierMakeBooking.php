<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\CourierMakeBooking;

class EcontCourierMakeBooking implements CourierMakeBooking
{
    public function makeBooking(): Booking
    {
        return new EcontBooking();
    }
}
