<?php

namespace TM\Repository;

use PDO;
use TM\Model\Assignment;

class AssignmentRepository {
    public function __construct(
        private PDO $pdo
    ){}

    public function findByUserIdAndTaskId(int $userId, int $taskId): ?Assignment {
        $sql = "SELECT id, user_id, task_id FROM assignments WHERE user_id = :user_id AND task_id = :task_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $userId,
            'task_id' => $taskId
        ]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false)
            return null;

        return $this->mapToAssignment($row);

    }

    public function findByUserId(int $id): array {
        $assignments = [];
        $sql = "SELECT id, user_id, task_id FROM assignments WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $assignments[] = $this->mapToAssignment($row);
        }

        return $assignments;
    }

    public function findByTaskId(int $id): array {
        $assignments = [];
        $sql = "SELECT id, user_id, task_id FROM assignments WHERE task_id = :task_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['task_id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $assignments[] = $this->mapToAssignment($row);
        }

        return $assignments;
    }

    public function save(Assignment $assignment): Assignment {
        $sql = "
        INSERT INTO assignments (
        user_id,
        task_id
        )
        VALUES (
        :user_id,
        :task_id
        )
        RETURNING id
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $assignment->getUserId(),
            'task_id' => $assignment->getTaskId()
        ]);

        $assignment->setId((int) $statement->fetchColumn());

        return $assignment;
    }

    private function mapToAssignment(array $row): Assignment {
        return new Assignment(
            $row['id'] !== null ? (int) $row['id'] : null,
            (int) $row['user_id'],
            (int) $row['task_id']
        );
    }
}