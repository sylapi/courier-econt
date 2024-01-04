<?php

namespace Sylapi\Courier\Econt\Tests\Unit;

use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Econt\StatusTransformer;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class StatusTransformerTest extends PHPUnitTestCase
{
    public function testStatusTransformer(): void
    {
        $statusTransformer = new StatusTransformer('reject');
        $this->assertEquals(StatusType::CANCELLED, (string) $statusTransformer);
    }
}
