<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt\Helpers;

class ApiErrorsHelper
{

    public static function buildErrorMessage(string $errors): ?string
    {
        $result = json_decode($errors, true);
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            //Json data response is incorrect
            return null;       
        }

        $message = 'Error:';
        array_walk_recursive($result, function($value, $key) use (&$message) {
            if($key === 'message') {
                $message .= $value;
            }
        });

        return $message;
    }
}