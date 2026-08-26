<?php

namespace App\Http\Controllers\Api;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = $this->taskService->listTasks(
            status: $request->query('status'),
            dueDate: $request->query('due_date'),
            priorityId: $request->integer('priority_id') ?: null
        );

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->toDto());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task->load(['priority', 'tags']));
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $updatedTask = $this->taskService->updateTask($task, $request->toDto());

        return new TaskResource($updatedTask);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): TaskResource
    {
        $status = TaskStatus::from($request->validated('status'));
        $updatedTask = $this->taskService->updateStatus($task, $status);

        return new TaskResource($updatedTask);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->deleteTask($task);

        return response()->json(null, 204);
    }
}
