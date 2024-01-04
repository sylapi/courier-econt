<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use Sylapi\Courier\Econt\Entities\Parcel;
use Sylapi\Courier\Econt\Entities\Sender;
use Sylapi\Courier\Econt\Entities\Receiver;
use Sylapi\Courier\Econt\Entities\Shipment;
use Sylapi\Courier\Econt\CourierCreateShipment;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\Tests\Helpers\SessionTrait;
use Sylapi\Courier\Econt\Responses\Shipment as ResponsesShipment;


class CourierCreateShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getShipmentMock()
    {
        $shipmentMock = $this->createMock(Shipment::class);
        $senderMock = $this->createMock(Sender::class);
        $receiverMock = $this->createMock(Receiver::class);
        $parcelMock = $this->createMock(Parcel::class);

        $shipmentMock->method('getSender')->willReturn($senderMock);
        $shipmentMock->method('getReceiver')->willReturn($receiverMock);
        $shipmentMock->method('getParcel')->willReturn($parcelMock);
        $shipmentMock->method('getContent')->willReturn('Description');
        $shipmentMock->method('validate')->willReturn(true);

        return $shipmentMock;
    }

    public function testCreateShipmentSuccess(): void
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 201,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierCreateShipmentSuccess.json'), 
            ]
        ]);

        $courierCreateShipment = new CourierCreateShipment($sessionMock);
        $response = $courierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(ResponsesShipment::class, $response);
        $this->assertEquals($response->getShipmentId(), '123');
    }
}
