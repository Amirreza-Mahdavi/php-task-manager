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
}