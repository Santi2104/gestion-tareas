<?php

namespace Tests\Unit\DataTransferObjects;

use App\DataTransferObjects\CreateTaskData;
use App\Enums\TaskStatus;
use PHPUnit\Framework\TestCase;

class CreateTaskDataTest extends TestCase
{
    public function test_can_instantiate_create_task_data_from_array(): void
    {
        $data = CreateTaskData::fromArray([
            'title' => 'Test Title',
            'priority_id' => 2,
            'description' => 'Test Desc',
            'status' => 'in_progress',
            'due_date' => '2026-09-01',
            'tag_ids' => [1, 3],
        ]);

        $this->assertEquals('Test Title', $data->title);
        $this->assertEquals(2, $data->priorityId);
        $this->assertEquals('Test Desc', $data->description);
        $this->assertEquals(TaskStatus::InProgress, $data->status);
        $this->assertEquals('2026-09-01', $data->dueDate);
        $this->assertEquals([1, 3], $data->tagIds);
    }
}
