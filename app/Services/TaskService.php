<?php

namespace App\Services;

use App\DataTransferObjects\CreateTaskData;
use App\DataTransferObjects\UpdateTaskData;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * List tasks with optional filters and eager-loaded relations.
     *
     * @return Collection<int, Task>
     */
    public function listTasks(?string $status = null, ?string $dueDate = null, ?int $priorityId = null): Collection
    {
        $query = Task::with(['priority', 'tags'])->latest();

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if ($dueDate !== null && $dueDate !== '') {
            $query->whereDate('due_date', $dueDate);
        }

        if ($priorityId !== null) {
            $query->where('priority_id', $priorityId);
        }

        return $query->get();
    }

    /**
     * Create a new task and attach tags.
     */
    public function createTask(CreateTaskData $data): Task
    {
        return DB::transaction(function () use ($data) {
            $task = Task::create([
                'title' => $data->title,
                'description' => $data->description,
                'status' => $data->status->value,
                'due_date' => $data->dueDate,
                'priority_id' => $data->priorityId,
            ]);

            if (! empty($data->tagIds)) {
                $task->tags()->sync($data->tagIds);
            }

            return $task->load(['priority', 'tags']);
        });
    }

    /**
     * Update an existing task.
     */
    public function updateTask(Task $task, UpdateTaskData $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $updateData = [];

            if ($data->title !== null) {
                $updateData['title'] = $data->title;
            }

            if ($data->hasDescription) {
                $updateData['description'] = $data->description;
            }

            if ($data->status !== null) {
                $updateData['status'] = $data->status->value;
            }

            if ($data->hasDueDate) {
                $updateData['due_date'] = $data->dueDate;
            }

            if ($data->priorityId !== null) {
                $updateData['priority_id'] = $data->priorityId;
            }

            if (! empty($updateData)) {
                $task->update($updateData);
            }

            if ($data->hasTagIds) {
                $task->tags()->sync($data->tagIds ?? []);
            }

            return $task->load(['priority', 'tags']);
        });
    }

    /**
     * Update only task status.
     */
    public function updateStatus(Task $task, TaskStatus $status): Task
    {
        $task->update(['status' => $status]);

        return $task->load(['priority', 'tags']);
    }

    /**
     * Delete a task.
     */
    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }
}
