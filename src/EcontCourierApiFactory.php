<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Courier;

class EcontCourierApiFactory
{
    private $EcontSessionFactory;

    public function __construct(EcontSessionFactory $EcontSessionFactory)
    {
        $this->EcontSessionFactory = $EcontSessionFactory;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function create(array $parameters): Courier
    {
        $session = $this->EcontSessionFactory
                    ->session(EcontParameters::create($parameters));

        return new Courier(
            new EcontCourierCreateShipment($session),
            new EcontCourierPostShipment($session),
            new EcontCourierGetLabels($session),
            new EcontCourierGetStatuses($session),
            new EcontCourierMakeShipment(),
            new EcontCourierMakeParcel(),
            new EcontCourierMakeReceiver(),
            new EcontCourierMakeSender(),
            new EcontCourierMakeBooking()
        );
    }
}
