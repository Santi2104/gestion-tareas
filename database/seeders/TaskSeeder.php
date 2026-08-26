<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $priorities = Priority::all();
        $tags = Tag::all();

        if ($priorities->isEmpty() || $tags->isEmpty()) {
            return;
        }

        Task::factory()->count(10)->create([
            'priority_id' => fn () => $priorities->random()->id,
        ])->each(function (Task $task) use ($tags) {
            $task->tags()->attach($tags->random(rand(1, 2))->pluck('id'));
        });
    }
}
