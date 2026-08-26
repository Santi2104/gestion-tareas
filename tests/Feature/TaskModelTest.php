<?php

namespace Tests\Feature;

use App\Enums\PriorityLevel;
use App\Enums\TagName;
use App\Enums\TaskStatus;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created_with_factory(): void
    {
        $priority = Priority::factory()->create(['name' => PriorityLevel::Low]);

        $task = Task::factory()->create([
            'title' => 'Test Task Title',
            'description' => 'Test Description',
            'status' => TaskStatus::Pending,
            'priority_id' => $priority->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Test Task Title',
            'status' => 'pending',
            'priority_id' => $priority->id,
        ]);
        $this->assertEquals(TaskStatus::Pending, $task->status);
    }

    public function test_task_belongs_to_priority(): void
    {
        $priority = Priority::factory()->create(['name' => PriorityLevel::High]);
        $task = Task::factory()->create(['priority_id' => $priority->id]);

        $this->assertInstanceOf(Priority::class, $task->priority);
        $this->assertEquals($priority->id, $task->priority->id);
    }

    public function test_task_belongs_to_many_tags(): void
    {
        $task = Task::factory()->create();
        $tagDev = Tag::factory()->create(['name' => TagName::Dev]);
        $tagQa = Tag::factory()->create(['name' => TagName::Qa]);

        $task->tags()->attach([$tagDev->id, $tagQa->id]);

        $this->assertCount(2, $task->tags);
        $this->assertTrue($task->tags->contains($tagDev));
        $this->assertTrue($task->tags->contains($tagQa));
    }
}
