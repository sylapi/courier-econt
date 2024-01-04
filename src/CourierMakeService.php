<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Econt\Entities\Service;
use Sylapi\Courier\Contracts\Service as ServiceContract;
use Sylapi\Courier\Contracts\CourierMakeService as CourierMakeServiceContract;
use Sylapi\Courier\ServiceFactory;

class CourierMakeService implements CourierMakeServiceContract
{
    public function makeService(?string $serviceType = null): ServiceContract
    {
        if($serviceType) {
            return ServiceFactory::create('Econt', $serviceType);
        }
        
        return new Service();
    }
}
