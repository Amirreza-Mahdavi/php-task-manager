<?php

namespace TM\DTO;

use DateTimeImmutable;
use TM\Enum\TaskStatus;
use TM\Enum\TaskPriority;

class CreateTaskRequest {
    public function __construct(
        private string $title,
        private ?string $description,
        private TaskStatus $status,
        private TaskPriority $priority,
        private DateTimeImmutable $dueDate, 
    ){}

    public function getTitle(): string {
        return $this->title;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function getStatus(): TaskStatus {
        return $this->status;
    }
    public function getPriority(): TaskPriority {
        return $this->priority;
    }
    public function getDueDate(): DateTimeImmutable {
        return $this->dueDate;
    }
}