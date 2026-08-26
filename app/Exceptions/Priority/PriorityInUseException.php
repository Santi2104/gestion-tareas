<?php

namespace App\Exceptions\Priority;

use App\Exceptions\BusinessException;

class PriorityInUseException extends BusinessException
{
    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(string $message = 'Priority is currently assigned to one or more tasks.', array $meta = [])
    {
        parent::__construct(
            message: $message,
            errorCode: 'PRIORITY_IN_USE',
            statusCode: 409,
            meta: $meta
        );
    }
}
