<?php

namespace Tests\Feature\Exceptions;

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class GlobalExceptionHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::post('/api/test-validation', function () {
            throw ValidationException::withMessages([
                'title' => ['The title field is required.'],
            ]);
        });
    }

    public function test_not_found_http_exception_returns_uniform_json(): void
    {
        $response = $this->getJson('/api/non-existent-endpoint');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'The requested resource was not found.',
                'error_code' => 'RESOURCE_NOT_FOUND',
                'meta' => [],
            ]);
    }

    public function test_validation_exception_returns_uniform_json(): void
    {
        $response = $this->postJson('/api/test-validation', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'error_code' => 'VALIDATION_ERROR',
                'meta' => [
                    'errors' => [
                        'title' => ['The title field is required.'],
                    ],
                ],
            ]);
    }
}
