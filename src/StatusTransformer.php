<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Abstracts\StatusTransformer as StatusTransformerAbstract;
use Sylapi\Courier\Enums\StatusType;

class StatusTransformer extends StatusTransformerAbstract
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'unprocess' => StatusType::NEW->value,    
        'process' => StatusType::PROCESSING->value,    
        'taken' => StatusType::SENT->value,    
        'reject' => StatusType::CANCELLED->value,    
        'reject_client' => StatusType::CANCELLED->value
    ];
}