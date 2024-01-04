<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use Sylapi\Courier\Econt\CourierGetLabels;
use Sylapi\Courier\Econt\Entities\LabelType;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Econt\Tests\Helpers\SessionTrait;

class CourierGetLabelsTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetLabelsSuccess(): void
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierGetLabelsSuccess.json'), 
            ]
        ]);

        $labelTypeMock = $this->createMock(LabelType::class);
        $courierGetLabels = new CourierGetLabels($sessionMock);
        $response = $courierGetLabels->getLabel('123', $labelTypeMock);
        $this->assertEquals($response, 'https://url-to-label.com.bg');
    }
}
