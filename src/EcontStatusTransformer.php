<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Sylapi\Courier\Abstracts\StatusTransformer;
use Sylapi\Courier\Enums\StatusType;

class EcontStatusTransformer extends StatusTransformer
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'unprocess' => StatusType::NEW,    
        'process' => StatusType::PROCESSING,    
        'taken' => StatusType::SENT,    
        'reject' => StatusType::CANCELLED,    
        'reject_client' => StatusType::CANCELLED
    ];
}