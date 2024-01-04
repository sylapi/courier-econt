<?php

namespace Sylapi\Courier\Econt\Tests\Integration;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Label;
use Sylapi\Courier\Econt\EcontCourierGetLabels;
use Sylapi\Courier\Econt\Tests\Helpers\EcontSessionTrait;

class CourierGetLabelsTest extends PHPUnitTestCase
{
    use EcontSessionTrait;

    public function testGetLabelsSuccess(): void
    {


        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/EcontCourierGetLabelsSuccess.json'), 
            ]
        ]);

        $econtCourierGetLabels = new EcontCourierGetLabels($sessionMock);

        $response = $econtCourierGetLabels->getLabel('123');
        $this->assertEquals($response, 'https://url-to-label.com.bg');
    }
}
