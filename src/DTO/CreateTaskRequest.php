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

    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getPriority(){
        return $this->priority;
    }
    public function getDueDate(){
        return $this->dueDate;
    }
}