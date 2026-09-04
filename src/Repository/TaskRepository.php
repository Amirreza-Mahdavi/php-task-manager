<?php

namespace TM\Repository;

use DateTimeImmutable;
use PDO;
use TM\Enum\TaskPriority;
use TM\Enum\TaskStatus;
use TM\Model\Task;

class TaskRepository {
    public function __construct(
        private PDO $pdo
    ){}

    public function findById(int $id): ?Task {
        $sql = "SELECT id, user_id, parent_task_id, title, description, status, priority, due_date, created_at, updated_at
        FROM tasks
        WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false)
            return null;

        return $this->mapToTask($row);
    }

    public function findByUserId(int $id): array {
        $tasks = [];

        $sql = "SELECT id, user_id, parent_task_id, title, description, status, priority, due_date, created_at, updated_at
        FROM tasks
        WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $tasks[] = $this->mapToTask($row);
        }

        return $tasks;
    }

    public function findByParentTaskId(int $taskId): array {
        $subtasks = [];

        $sql = "SELECT id, user_id, parent_task_id, title, description, status, priority, due_date, created_at, updated_at
        FROM tasks
        WHERE parent_task_id = :parent_task_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['parent_task_id' => $taskId]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $subtasks[] = $this->mapToTask($row);
        }

        return $subtasks;
    }

    public function save(Task $task): Task {
        if ($task->getId() === null)
            return $this->insert($task);
        else 
            return $this->update($task);
    }

    private function insert(Task $task): Task {
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
        updated_at
        )
        VALUES (
        :parent_task_id,
        :user_id,
        :title,
        :description,
        :status,
        :priority,
        :due_date,
        :created_at,
        :updated_at
        )
        RETURNING id
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'parent_task_id' => $task->getParentTaskId(),
            'user_id' => $task->getUserId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus()->value,
            'priority' => $task->getPriority()->value,
            'due_date' => $task->getDueDate()?->format('Y-m-d H:i:s'),
            'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            "updated_at" => $task->getUpdatedAt()->format('Y-m-d H:i:s')
        ]);

        $task->setId((int) $statement->fetchColumn());

        return $task;
    }

    private function update(Task $task): Task {
        $sql = "
        UPDATE tasks 
        SET
        title = :title,
        description = :description,
        status = :status,
        priority = :priority,
        due_date = :due_date,
        updated_at =:updated_at
        WHERE id = :id
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus()->value,
            'priority' => $task->getPriority()->value,
            'due_date' => $task->getDueDate()?->format('Y-m-d H:i:s'),
            'updated_at' => $task->getUpdatedAt()->format('Y-m-d H:i:s')
        ]);

        return $task;
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    private function mapToTask(array $row): Task {
        return new Task(
            $row['id'] !== null ? (int) $row['id'] : null,
            $row['parent_task_id'] !== null ? (int) $row['parent_task_id'] : null,
            (int) $row['user_id'],
            $row['title'],
            $row['description'],
            TaskStatus::from($row['status']),
            TaskPriority::from($row['priority']),
            new DateTimeImmutable($row['due_date']),
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at'])
        );
    }
}