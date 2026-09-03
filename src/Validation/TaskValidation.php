<?php

namespace TM\Validation;

use TM\Enum\TaskPriority;
use TM\Enum\TaskStatus;
use TM\Exception\ValidationException;

class TaskValidation {
    public function validate(array $data){
        if(empty($data['title']) || strlen($data['title']) > 150)
            throw new ValidationException("Task title is required and cannot exceed 150 characters");
        if(strlen($data['description']) > 2000)
            throw new ValidationException("Task description cannot exceed 2000 characters");
        if(
            !isset($data['status']) || 
            !in_array(
                $data['status'],
                array_column(TaskStatus::cases(), 'value'),
                true
            )
        ){
            throw new ValidationException("Invalid Task status");
        }
        if(
            !isset($data['priority']) || 
            !in_array(
                $data['priority'],
                array_column(TaskPriority::cases(), 'value'),
                true
            )
        ){
            throw new ValidationException("Invalid Task priority");
        }
        if(
            !isset($data['dueDate']) ||
            !$data['dueDate'] instanceof \DateTimeImmutable
        )
        throw new ValidationException("Invalid due date");
    }
}