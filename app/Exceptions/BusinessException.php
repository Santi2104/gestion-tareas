<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BusinessException extends Exception
{
    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(
        string $message = 'Business rule violation.',
        protected string $errorCode = 'BUSINESS_RULE_VIOLATION',
        protected int $statusCode = 422,
        protected array $meta = []
    ) {
        parent::__construct($message, $statusCode);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, mixed>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    public function report(): bool
    {
        return false;
    }

    /**
     * Renderiza la excepción en una respuesta JSON estandarizada.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => $this->errorCode,
            'meta' => $this->meta,
        ], $this->statusCode);
    }
}
