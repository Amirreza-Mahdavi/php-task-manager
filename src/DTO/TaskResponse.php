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
            'status' => $this->status,
            'priority' => $this->priority,
            'dueDate' => $this-> dueDate,
            'createdAt' => $this->createdAt,
            'updatedat' => $this->updatedAt
        ];
    }
}