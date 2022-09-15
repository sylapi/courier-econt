<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Contracts\CourierMakeReceiver;
use Sylapi\Courier\Contracts\Receiver;

class EcontCourierMakeReceiver implements CourierMakeReceiver
{
    public function makeReceiver(): Receiver
    {
        return new EcontReceiver();
    }
}
