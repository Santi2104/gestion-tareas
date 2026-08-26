<?php

namespace Tests\Feature\Exceptions;

use App\Exceptions\Priority\PriorityInUseException;
use App\Exceptions\Tag\TagInUseException;
use App\Exceptions\Task\InvalidTaskStatusTransitionException;
use App\Exceptions\Task\TaskNotFoundException;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BusinessExceptionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/api/test-task-not-found', function () {
            throw new TaskNotFoundException('Task #999 was not found.');
        });

        Route::get('/api/test-invalid-status', function () {
            throw new InvalidTaskStatusTransitionException('Cannot reopen completed task.');
        });

        Route::get('/api/test-priority-in-use', function () {
            throw new PriorityInUseException;
        });

        Route::get('/api/test-tag-in-use', function () {
            throw new TagInUseException;
        });
    }

    public function test_task_not_found_exception_renders_uniform_json(): void
    {
        $response = $this->getJson('/api/test-task-not-found');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Task #999 was not found.',
                'error_code' => 'TASK_NOT_FOUND',
                'meta' => [],
            ]);
    }

    public function test_invalid_task_status_transition_exception_renders_uniform_json(): void
    {
        $response = $this->getJson('/api/test-invalid-status');

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot reopen completed task.',
                'error_code' => 'INVALID_TASK_STATUS_TRANSITION',
                'meta' => [],
            ]);
    }

    public function test_priority_in_use_exception_renders_uniform_json(): void
    {
        $response = $this->getJson('/api/test-priority-in-use');

        $response->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'Priority is currently assigned to one or more tasks.',
                'error_code' => 'PRIORITY_IN_USE',
                'meta' => [],
            ]);
    }

    public function test_tag_in_use_exception_renders_uniform_json(): void
    {
        $response = $this->getJson('/api/test-tag-in-use');

        $response->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'Tag is currently associated with one or more tasks.',
                'error_code' => 'TAG_IN_USE',
                'meta' => [],
            ]);
    }

    public function test_business_exception_does_not_report_to_log(): void
    {
        $exception = new TaskNotFoundException;
        $this->assertFalse($exception->report());
    }
}
