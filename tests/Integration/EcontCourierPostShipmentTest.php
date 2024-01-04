<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Econt\EcontBooking;
use Sylapi\Courier\Econt\EcontCourierPostShipment;
use Sylapi\Courier\Econt\Tests\Helpers\EcontSessionTrait;

class CourierPostShipmentTest extends PHPUnitTestCase
{
    use EcontSessionTrait;

    private function getBookingMock($shipmentId)
    {
        $bookingMock = $this->createMock(EcontBooking::class);
        $bookingMock->method('getShipmentId')->willReturn($shipmentId);
        $bookingMock->method('validate')->willReturn(true);

        return $bookingMock;
    }

    public function testPostShipmentSuccess(): void
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 201,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierPostShipmentSuccess.json'),
            ],
        ]);

        $econtCourierCreateShipment = new EcontCourierPostShipment($sessionMock);
        $shipmentId = 1234567890;
        $booking = $this->getBookingMock($shipmentId);
        $response = $econtCourierCreateShipment->postShipment($booking);

    
        $this->assertInstanceOf(Response::class, $response);
        $this->assertObjectHasAttribute('courierRequestID', $response);
        $this->assertNotEmpty($response->courierRequestID);
        $this->assertEquals('2018040000000954', $response->courierRequestID);
    }
}
