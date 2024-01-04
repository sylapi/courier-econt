<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use Sylapi\Courier\Contracts\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Econt\EcontCourierGetStatuses;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\Tests\Helpers\EcontSessionTrait;

class CourierGetStatusesTest extends PHPUnitTestCase
{
    use EcontSessionTrait;

    public function testGetStatusSuccess(): void
    {


        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierGetStatusSuccess.json'),
            ],
        ]);

        $econtCourierGetStatuses = new EcontCourierGetStatuses($sessionMock);

        $response = $econtCourierGetStatuses->getStatus('123');
        $this->assertInstanceOf(Status::class, $response);
        $this->assertEquals((string) $response, StatusType::SENT);


    }
}
