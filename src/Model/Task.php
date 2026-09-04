<?php

namespace TM\Model;

use DateTimeImmutable;
use TM\Enum\TaskStatus;
use TM\Enum\TaskPriority;

class Task {
    private ?int $id;
    private ?int $parentTaskId;
    private int $userId;
    private string $title;
    private ?string $description;
    private TaskStatus $status;
    private TaskPriority $priority;
    private DateTimeImmutable $dueDate;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        ?int $id = null,
        ?int $parentTaskId = null,
        ?int $userId = null,
        ?string $title = null,
        ?string $description = null,
        ?TaskStatus $status = null,
        ?TaskPriority $priority = null,
        ?DateTimeImmutable $dueDate = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->parentTaskId = $parentTaskId;
        $this->description = $description;

        if ($userId !== null) $this->userId = $userId;
        if ($title !== null) $this->title = $title;
        if ($status !== null) $this->status = $status;
        if ($priority !== null) $this->priority = $priority;
        if ($dueDate !== null) $this->dueDate = $dueDate;
        if ($createdAt !== null) $this->createdAt = $createdAt;
        if ($updatedAt !== null) $this->updatedAt = $updatedAt;
    }

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