<?php

namespace App\Exceptions\Task;

use App\Exceptions\BusinessException;

class TaskNotFoundException extends BusinessException
{
    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(string $message = 'Task not found.', array $meta = [])
    {
        parent::__construct(
            message: $message,
            errorCode: 'TASK_NOT_FOUND',
            statusCode: 404,
            meta: $meta
        );
    }
}
