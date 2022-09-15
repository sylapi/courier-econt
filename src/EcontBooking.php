<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Booking;

class EcontBooking extends Booking
{
    public function validate(): bool
    {
        $rules = [
            'shipmentId' => 'required',
        ];
        $data = [
           
        ];

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
