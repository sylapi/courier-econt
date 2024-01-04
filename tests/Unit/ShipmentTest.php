<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use Sylapi\Courier\Econt\Entities\Parcel;
use Sylapi\Courier\Econt\Entities\Sender;
use Sylapi\Courier\Econt\Entities\Receiver;
use Sylapi\Courier\Econt\Entities\Shipment;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ShipmentTest extends PHPUnitTestCase
{
    public function testNumberOfPackagesIsAlwaysEqualTo1(): void
    {
        $parcel = new Parcel();
        $shipment = new Shipment();
        $shipment->setParcel($parcel);
        $shipment->setParcel($parcel);

        $this->assertEquals(1, $shipment->getQuantity());
    }

    public function testShipmentValidate(): void
    {
        $receiver = new Receiver();
        $sender = new Sender();
        $parcel = new Parcel();

        $shipment = new Shipment();
        $shipment->setSender($sender)
            ->setReceiver($receiver)
            ->setParcel($parcel);

        $this->assertIsBool($shipment->validate());
        $this->assertIsBool($shipment->getReceiver()->validate());
        $this->assertIsBool($shipment->getSender()->validate());
        $this->assertIsBool($shipment->getParcel()->validate());
    }
}
