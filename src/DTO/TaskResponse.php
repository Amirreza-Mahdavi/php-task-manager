<?php

namespace TM\DTO;

use DateTimeImmutable;
use TM\Enum\TaskStatus;
use TM\Enum\TaskPriority;

class TaskResponse {
    public function __construct(
        private string $title,
        private string $description,
        private TaskStatus $status,
        private TaskPriority $priority,
        private DateTimeImmutable $dueDate,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt
    ){}

    public function toArray(): array {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'priority' => $this->priority->value,
            'dueDate' => $this->dueDate->format('Y-m-d H:i:s'),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
}