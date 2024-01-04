<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\EcontParcel;
use Sylapi\Courier\Econt\EcontReceiver;
use Sylapi\Courier\Econt\EcontSender;
use Sylapi\Courier\Econt\EcontShipment;

class ShipmentTest extends PHPUnitTestCase
{
    public function testNumberOfPackagesIsAlwaysEqualTo1(): void
    {
        $parcel = new EcontParcel();
        $shipment = new EcontShipment();
        $shipment->setParcel($parcel);
        $shipment->setParcel($parcel);

        $this->assertEquals(1, $shipment->getQuantity());
    }

    public function testShipmentValidate(): void
    {
        $receiver = new EcontReceiver();
        $sender = new EcontSender();
        $parcel = new EcontParcel();

        $shipment = new EcontShipment();
        $shipment->setSender($sender)
            ->setReceiver($receiver)
            ->setParcel($parcel);

        $this->assertIsBool($shipment->validate());
        $this->assertIsBool($shipment->getReceiver()->validate());
        $this->assertIsBool($shipment->getSender()->validate());
        $this->assertIsBool($shipment->getParcel()->validate());
    }
}
