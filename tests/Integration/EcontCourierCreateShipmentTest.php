<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Econt\EcontCourierCreateShipment;
use Sylapi\Courier\Econt\EcontParcel;
use Sylapi\Courier\Econt\EcontReceiver;
use Sylapi\Courier\Econt\EcontSender;
use Sylapi\Courier\Econt\EcontShipment;
use Sylapi\Courier\Econt\Tests\Helpers\EcontSessionTrait;

class CourierCreateShipmentTest extends PHPUnitTestCase
{
    use EcontSessionTrait;

    private function getShipmentMock()
    {
        $shipmentMock = $this->createMock(EcontShipment::class);
        $senderMock = $this->createMock(EcontSender::class);
        $receiverMock = $this->createMock(EcontReceiver::class);
        $parcelMock = $this->createMock(EcontParcel::class);

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

        $econtCourierCreateShipment = new EcontCourierCreateShipment($sessionMock);
        $response = $econtCourierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(Response::class, $response);
        // $this->assertObjectHasAttribute('referenceId', $response);
        // $this->assertObjectHasAttribute('shipmentId', $response);
        // $this->assertEquals($response->shipmentId, '123');
    }
}
