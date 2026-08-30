<?php

namespace TM\Repository;

use PDO;
use TM\Model\Task;

class TaskReposotory {
    public function __construct(
        private PDO $pdo
    ){}

    public function findByUserId(int $id): array {
        $tasks = [];

        $sql = "SELECT id, title, description, status, priority, due_date, created_at, updated_at FROM tasks WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $this->mapToTask($row);
        }

        return $tasks;
    }

    public function findByParentTaskId(int $taskId): array {
        $subTasks = [];

        $sql = "SELECT id, title, description, status, priority, due_date, created_at, updated_at FROM tasks
        WHERE parent_task_id = :parent_task_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['parent_task_id' => $taskId]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $this->mapToTask($row);
        }

        return $subTasks;
    }

    public function save(Task $task): void {
        if ($task->getId() === 0)
            $this->insert($task);

        $this->update($task);
    }

    private function insert(Task $task): void {
        $sql = "
        INSERT INTO tasks (
        parent_task_id,
        user_id,
        title,
        description,
        status,
        priority,
        due_date,
        created_at,
        created_at,
        updated_at
        )
        VALUES (
        :parent_task_id
        :user_id,
        :title,
        :description,
        :status,
        :priority,
        :due_date,
        :created_at,
        :created_at,
        :updated_at
        )
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'parent_task_id' => $task->getParentTaskId(),
            'user_id' => $task->getUserId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'priority' => $task->getPriority(),
            'due_date' => $task->getDueDate(),
            'created_at' => $task->getCreatedAt(),
            "updated_at" => $task->getUpdatedAt()
        ]);

        $task->setId((int) $this->pdo->lastInsertId());
    }

    private function update(Task $task): void {
        $sql = "
        UPDATE tasks 
        SET
        title = :title,
        description = :description,
        status = :status,
        priority = :priority,
        due_date = :due_date,
        updated_at =:updated_at
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'priority' => $task->getPriority(),
            'due_date' => $task->getDueDate(),
            'updated_at' => $task->getUpdatedAt()
        ]);
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    private function mapToTask(array $row): Task {
        return new Task(
            (int) $row['id'],
            (int) $row['parent_task_id'],
            (int) $row['user_id'],
            $row['title'],
            $row['description'],
            $row['status'],
            $row['priority'],
            $row['due_date'],
            $row['created_at'],
            $row['updated_at']
        );
    }

}