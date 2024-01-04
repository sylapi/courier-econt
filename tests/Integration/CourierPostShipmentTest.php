<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use Sylapi\Courier\Econt\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Econt\Entities\Booking;
use Sylapi\Courier\Econt\CourierPostShipment;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\Tests\Helpers\SessionTrait;

class CourierPostShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getBookingMock($shipmentId)
    {
        $bookingMock = $this->createMock(Booking::class);
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

        $courierCreateShipment = new CourierPostShipment($sessionMock);
        $shipmentId = 1234567890;
        $booking = $this->getBookingMock($shipmentId);
        $response = $courierCreateShipment->postShipment($booking);

        $this->assertInstanceOf(ParcelResponse::class, $response);
        $this->assertEquals('2018040000000954', $response->getCourierRequestId());
    }
}
