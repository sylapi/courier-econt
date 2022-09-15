<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Contracts\CourierMakeSender;
use Sylapi\Courier\Contracts\Sender;

class EcontCourierMakeSender implements CourierMakeSender
{
    public function makeSender(): Sender
    {
        return new EcontSender();
    }
}
