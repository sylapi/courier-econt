<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use Sylapi\Courier\Courier;
use Sylapi\Courier\Econt\Session;
use Sylapi\Courier\Econt\SessionFactory;
use Sylapi\Courier\Econt\Entities\Parcel;
use Sylapi\Courier\Econt\Entities\Sender;
use Sylapi\Courier\Econt\Entities\Booking;
use Sylapi\Courier\Econt\CourierApiFactory;
use Sylapi\Courier\Econt\Entities\Receiver;
use Sylapi\Courier\Econt\Entities\Shipment;
use Sylapi\Courier\Econt\Entities\Credentials;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    public function testEcontSessionFactory(): void
    {
        $credentials = new Credentials();
        $credentials->setLogin('login');
        $credentials->setPassword('password');
        $credentials->setSandbox(true);
        $sessionFactory = new SessionFactory();
        $session = $sessionFactory->session(
            $credentials
        );
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testCourierFactoryCreate(): void
    {
        $credentials = [
            'login' => 'login',
            'password' => 'password',
            'sandbox' => true,
        ];

        $courierApiFactory = new CourierApiFactory(new SessionFactory());
        $courier = $courierApiFactory->create($credentials);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(Booking::class, $courier->makeBooking());
        $this->assertInstanceOf(Parcel::class, $courier->makeParcel());
        $this->assertInstanceOf(Receiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(Sender::class, $courier->makeSender());
        $this->assertInstanceOf(Shipment::class, $courier->makeShipment());
    }
}
