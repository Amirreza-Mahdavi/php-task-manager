<?php

namespace TM\Model;

class Assignment {
    public function __construct(
        private readonly ?int $id,
        private readonly int $userId,
        private readonly int $taskId
    ){}

    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getTaskId(){
        return $this->taskId;
    }

    public function setId(int $id){
        $this->id = $id;
    }
}