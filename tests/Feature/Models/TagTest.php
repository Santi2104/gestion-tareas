<?php

namespace Tests\Feature\Models;

use App\Enums\TagName;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_can_be_created_with_factory(): void
    {
        $tag = Tag::factory()->create([
            'name' => TagName::Dev,
        ]);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'DEV',
        ]);
        $this->assertEquals(TagName::Dev, $tag->name);
    }

    public function test_tag_belongs_to_many_tasks(): void
    {
        $tag = Tag::factory()->create(['name' => TagName::Qa]);
        $tasks = Task::factory()->count(2)->create();

        $tag->tasks()->attach($tasks->pluck('id'));

        $this->assertCount(2, $tag->tasks);
        $this->assertTrue($tag->tasks->contains($tasks->first()));
    }
}
