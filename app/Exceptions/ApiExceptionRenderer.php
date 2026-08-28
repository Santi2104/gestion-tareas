<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptionRenderer
{
    public function __invoke(Exceptions $exceptions): void
    {
        $exceptions->render(fn (ValidationException $e, Request $request) => $this->handleValidation($e, $request));
        $exceptions->render(fn (NotFoundHttpException $e, Request $request) => $this->handleNotFound($e, $request));
        $exceptions->render(fn (AuthenticationException $e, Request $request) => $this->handleUnauthenticated($e, $request));
    }

    protected function handleValidation(ValidationException $e, Request $request): ?JsonResponse
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'error_code' => 'VALIDATION_ERROR',
                'meta' => [
                    'errors' => $e->errors(),
                ],
            ], 422);
        }

        return null;
    }

    protected function handleNotFound(NotFoundHttpException $e, Request $request): ?JsonResponse
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'success' => false,
                'message' => 'The requested resource was not found.',
                'error_code' => 'RESOURCE_NOT_FOUND',
                'meta' => [],
            ], 404);
        }

        return null;
    }

    protected function handleUnauthenticated(AuthenticationException $e, Request $request): ?JsonResponse
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
                'error_code' => 'UNAUTHENTICATED',
                'meta' => [],
            ], 401);
        }

        return null;
    }

    protected function shouldReturnJson(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }
}
