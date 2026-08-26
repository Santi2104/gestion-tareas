<?php

namespace App\Exceptions\Task;

use App\Exceptions\BusinessException;

class InvalidTaskStatusTransitionException extends BusinessException
{
    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(string $message = 'Invalid task status transition.', array $meta = [])
    {
        parent::__construct(
            message: $message,
            errorCode: 'INVALID_TASK_STATUS_TRANSITION',
            statusCode: 422,
            meta: $meta
        );
    }
}
