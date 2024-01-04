<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Courier;
use Sylapi\Courier\Econt\EcontBooking;
use Sylapi\Courier\Econt\EcontCourierApiFactory;
use Sylapi\Courier\Econt\EcontParameters;
use Sylapi\Courier\Econt\EcontParcel;
use Sylapi\Courier\Econt\EcontReceiver;
use Sylapi\Courier\Econt\EcontSender;
use Sylapi\Courier\Econt\EcontSession;
use Sylapi\Courier\Econt\EcontSessionFactory;
use Sylapi\Courier\Econt\EcontShipment;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    /**
     * @var array<string,mixed>
     */
    private $parameters = [
        'login'           => 'login',
        'password'        => 'password',
        'sandbox'         => false
    ];

    public function testEcontSessionFactory(): void
    {
        $EcontSessionFactory = new EcontSessionFactory();
        $EcontSession = $EcontSessionFactory->session(
            EcontParameters::create($this->parameters)
        );
        $this->assertInstanceOf(EcontSession::class, $EcontSession);
    }

    public function testCourierFactoryCreate(): void
    {
        $EcontCourierApiFactory = new EcontCourierApiFactory(new EcontSessionFactory());
        $courier = $EcontCourierApiFactory->create($this->parameters);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(EcontBooking::class, $courier->makeBooking());
        $this->assertInstanceOf(EcontParcel::class, $courier->makeParcel());
        $this->assertInstanceOf(EcontReceiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(EcontSender::class, $courier->makeSender());
        $this->assertInstanceOf(EcontShipment::class, $courier->makeShipment());
    }
}
