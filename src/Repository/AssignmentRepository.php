<?php

namespace TM\Repository;

use PDO;
use TM\Model\Assignment;

class AssignmentRepository {
    public function __construct(
        private PDO $pdo
    ){}

    public function findByUserId(int $id): array {
        $assignments = [];
        $sql = "SELECT id, user_id, task_id FROM assignments WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $assignment[] = $this->mapToAssignemnt($row);
        }

        return $assignments;
    }

    public function finByTaskId(int $id): array {
        $assignments = [];
        $sql = "SELECT id, user_id, task_id FROM assignments WHERE task_id = :task_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['task_id' => $id]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $assignment[] = $this->mapToAssignemnt($row);
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
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $assignment->getUserId(),
            'task_id' => $assignment->getTaskId()
        ]);

        $assignment->setId((int) $this->pdo->lastInsertId());

        return $assignment;
    }

    private function mapToAssignemnt(array $row): Assignment {
        return new Assignment(
            (int) $row['id'],
            (int) $row['user_id'],
            (int) $row['task_id']
        );
    }
}