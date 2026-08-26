<?php

namespace Tests\Feature;

use App\Enums\PriorityLevel;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_priority_can_be_created_with_factory(): void
    {
        $priority = Priority::factory()->create([
            'name' => PriorityLevel::High,
        ]);

        $this->assertDatabaseHas('priorities', [
            'id' => $priority->id,
            'name' => 'high',
        ]);
        $this->assertEquals(PriorityLevel::High, $priority->name);
    }

    public function test_priority_has_many_tasks(): void
    {
        $priority = Priority::factory()->create(['name' => PriorityLevel::Medium]);
        $tasks = Task::factory()->count(3)->create(['priority_id' => $priority->id]);

        $this->assertCount(3, $priority->tasks);
        $this->assertTrue($priority->tasks->contains($tasks->first()));
    }
}
