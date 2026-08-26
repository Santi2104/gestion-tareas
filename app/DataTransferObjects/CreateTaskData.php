<?php

namespace App\DataTransferObjects;

use App\Enums\TaskStatus;

readonly class CreateTaskData
{
    /**
     * @param  array<int, int>  $tagIds
     */
    public function __construct(
        public string $title,
        public int $priorityId,
        public ?string $description = null,
        public TaskStatus $status = TaskStatus::Pending,
        public ?string $dueDate = null,
        public array $tagIds = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            priorityId: (int) $data['priority_id'],
            description: $data['description'] ?? null,
            status: isset($data['status']) ? TaskStatus::from($data['status']) : TaskStatus::Pending,
            dueDate: $data['due_date'] ?? null,
            tagIds: isset($data['tag_ids']) && is_array($data['tag_ids']) ? array_map('intval', $data['tag_ids']) : [],
        );
    }
}
