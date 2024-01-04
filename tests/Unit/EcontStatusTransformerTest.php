<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Econt\EcontStatusTransformer;

class StatusTransformerTest extends PHPUnitTestCase
{
    public function testStatusTransformer(): void
    {
        $EcontStatusTransformer = new EcontStatusTransformer('reject');
        $this->assertEquals(StatusType::CANCELLED, (string) $EcontStatusTransformer);
    }
}
