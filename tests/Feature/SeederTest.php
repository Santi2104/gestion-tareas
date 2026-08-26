<?php

namespace Tests\Feature;

use App\Enums\PriorityLevel;
use App\Enums\TagName;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_priorities_tags_and_tasks(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertCount(count(PriorityLevel::cases()), Priority::all());
        $this->assertCount(count(TagName::cases()), Tag::all());
        $this->assertGreaterThan(0, Task::count());
    }
}
