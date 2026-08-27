<?php

namespace Tests\Feature\Api;

use App\Enums\PriorityLevel;
use App\Enums\TagName;
use App\Enums\TaskStatus;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_unauthenticated_user_cannot_access_tasks_api(): void
    {
        $this->app['auth']->forgetGuards();

        $response = $this->getJson(route('tasks.index'));

        $response->assertUnauthorized();
    }

    public function test_can_list_all_tasks(): void
    {
        $priority = Priority::factory()->create();
        Task::factory()->count(3)->create(['priority_id' => $priority->id]);

        $response = $this->getJson(route('tasks.index'));

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'status', 'due_date', 'priority_id', 'priority', 'tags', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_filter_tasks_by_status(): void
    {
        $priority = Priority::factory()->create();
        Task::factory()->create(['status' => TaskStatus::Pending, 'priority_id' => $priority->id]);
        Task::factory()->create(['status' => TaskStatus::Completed, 'priority_id' => $priority->id]);

        $response = $this->getJson(route('tasks.index', ['status' => TaskStatus::Completed->value]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.status', TaskStatus::Completed->value);
    }

    public function test_can_filter_tasks_by_due_date(): void
    {
        $priority = Priority::factory()->create();
        Task::factory()->create(['due_date' => '2026-09-01', 'priority_id' => $priority->id]);
        Task::factory()->create(['due_date' => '2026-09-15', 'priority_id' => $priority->id]);

        $response = $this->getJson(route('tasks.index', ['due_date' => '2026-09-01']));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.due_date', '2026-09-01');
    }

    public function test_can_create_task_with_priority_and_tags(): void
    {
        $priority = Priority::factory()->create(['name' => PriorityLevel::High]);
        $tagDev = Tag::factory()->create(['name' => TagName::Dev]);
        $tagQa = Tag::factory()->create(['name' => TagName::Qa]);

        $payload = [
            'title' => 'New Feature Task',
            'description' => 'Detailed description of the task',
            'status' => TaskStatus::Pending->value,
            'due_date' => '2026-09-10',
            'priority_id' => $priority->id,
            'tag_ids' => [$tagDev->id, $tagQa->id],
        ];

        $response = $this->postJson(route('tasks.store'), $payload);

        $response->assertCreated()
            ->assertJsonPath('data.title', 'New Feature Task')
            ->assertJsonPath('data.priority_id', $priority->id)
            ->assertJsonCount(2, 'data.tags');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Feature Task',
            'priority_id' => $priority->id,
        ]);
        $this->assertDatabaseHas('tag_task', [
            'tag_id' => $tagDev->id,
        ]);
    }

    public function test_create_task_fails_validation_for_missing_required_fields(): void
    {
        $response = $this->postJson(route('tasks.store'), []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error_code' => 'VALIDATION_ERROR',
            ])
            ->assertJsonPath('meta.errors.title.0', 'The title field is required.')
            ->assertJsonPath('meta.errors.priority_id.0', 'The priority id field is required.');
    }

    public function test_can_show_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.show', $task));

        $response->assertOk()
            ->assertJsonPath('data.id', $task->id)
            ->assertJsonPath('data.title', $task->title);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create(['title' => 'Old Title']);
        $newPriority = Priority::firstOrCreate(['name' => PriorityLevel::High->value]);

        $payload = [
            'title' => 'Updated Title',
            'priority_id' => $newPriority->id,
        ];

        $response = $this->putJson(route('tasks.update', $task), $payload);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.priority_id', $newPriority->id);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_update_task_status(): void
    {
        $task = Task::factory()->create(['status' => TaskStatus::Pending]);

        $response = $this->patchJson(route('tasks.update-status', $task), [
            'status' => TaskStatus::Completed->value,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', TaskStatus::Completed->value);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => TaskStatus::Completed->value,
        ]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
