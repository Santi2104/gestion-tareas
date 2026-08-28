<?php

namespace App\DataTransferObjects;

use App\Enums\TaskStatus;

readonly class UpdateTaskData
{
    /**
     * @param  array<int, int>|null  $tagIds
     */
    public function __construct(
        public ?string $title = null,
        public ?int $priorityId = null,
        public ?string $description = null,
        public ?TaskStatus $status = null,
        public ?string $dueDate = null,
        public ?array $tagIds = null,
        public bool $hasDescription = false,
        public bool $hasDueDate = false,
        public bool $hasTagIds = false,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            priorityId: isset($data['priority_id']) ? (int) $data['priority_id'] : null,
            description: $data['description'] ?? null,
            status: isset($data['status']) ? TaskStatus::from($data['status']) : null,
            dueDate: $data['due_date'] ?? null,
            tagIds: isset($data['tag_ids']) && is_array($data['tag_ids']) ? array_map('intval', $data['tag_ids']) : null,
            hasDescription: array_key_exists('description', $data),
            hasDueDate: array_key_exists('due_date', $data),
            hasTagIds: array_key_exists('tag_ids', $data),
        );
    }
}
