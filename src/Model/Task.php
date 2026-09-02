<?php

namespace TM\Model;

use DateTimeImmutable;
use TM\Enum\TaskStatus;
use TM\Enum\TaskPriority;

class Task {
    private ?int $id;
    private readonly ?int $parentTaskId;
    private readonly int $userId;
    private string $title;
    private ?string $description;
    private TaskStatus $status;
    private TaskPriority $priority;
    private DateTimeImmutable $dueDate;
    private readonly DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function getId(){
        return $this->id;
    }
    public function getParentTaskId(){
        return $this->parentTaskId;
    }
    public function getUserId(){
        return $this->userId;
    }
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
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function setId(int $id){
        $this->id = $id;
    }
    public function setTaskId(int $id): void {
        $this->parentTaskId = $id;
    }
    public function setUserId(int $id){
        $this->userId = $id;
    }
    public function setTitle(string $title){
        $this->title = $title;
    }
    public function setDescription(string $description){
        $this->description = $description;
    }
    public function setStatus(TaskStatus $status){
        $this->status = $status;
    }
    public function setPriority(TaskPriority $priority){
        $this->priority = $priority;
    }
    public function setDueDate(DateTimeImmutable $dueDate){
        $this->dueDate = $dueDate;
    }
    public function setCreatedAt(DateTimeImmutable $createdAt){
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(DateTimeImmutable $updatedAt){
        $this->updatedAt = $updatedAt;
    }
}