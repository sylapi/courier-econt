<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use Sylapi\Courier\Contracts\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Econt\CourierGetStatuses;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\Tests\Helpers\SessionTrait;


class CourierGetStatusesTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetStatusSuccess(): void
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierGetStatusSuccess.json'),
            ],
        ]);

        $courierGetStatuses = new CourierGetStatuses($sessionMock);

        $response = $courierGetStatuses->getStatus('123');
        $this->assertEquals($response, StatusType::SENT->value);


    }
}
