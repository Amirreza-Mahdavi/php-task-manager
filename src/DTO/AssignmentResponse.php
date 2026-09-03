<?php

namespace TM\DTO;

class AssignmentResponse {
    public function __construct(
        private int $id,
        private int $userId,
        private int $taskId 
    ){}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'taskId' => $this->taskId
        ];
    }
}