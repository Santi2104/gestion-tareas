<?php

namespace Tests\Unit\DataTransferObjects;

use App\DataTransferObjects\UpdateTaskData;
use App\Enums\TaskStatus;
use PHPUnit\Framework\TestCase;

class UpdateTaskDataTest extends TestCase
{
    public function test_can_instantiate_update_task_data_from_partial_array(): void
    {
        $data = UpdateTaskData::fromArray([
            'title' => 'Updated Title',
            'status' => 'completed',
        ]);

        $this->assertEquals('Updated Title', $data->title);
        $this->assertEquals(TaskStatus::Completed, $data->status);
        $this->assertNull($data->priorityId);
        $this->assertFalse($data->hasDescription);
        $this->assertFalse($data->hasTagIds);
    }
}
