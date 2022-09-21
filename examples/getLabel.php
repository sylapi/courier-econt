<?php

use Sylapi\Courier\CourierFactory;

$courier = CourierFactory::create('Econt', [
    'login'           => 'mylogin',
    'password'        => 'mypassword',
    'sandbox'         => false,
]);

/**
 * GetLabel.
 */

 // ...