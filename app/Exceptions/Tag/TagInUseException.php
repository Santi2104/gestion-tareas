<?php

namespace App\Exceptions\Tag;

use App\Exceptions\BusinessException;

class TagInUseException extends BusinessException
{
    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(string $message = 'Tag is currently associated with one or more tasks.', array $meta = [])
    {
        parent::__construct(
            message: $message,
            errorCode: 'TAG_IN_USE',
            statusCode: 409,
            meta: $meta
        );
    }
}
