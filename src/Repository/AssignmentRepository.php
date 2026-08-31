<?php

namespace TM\Repository;

use PDO;

class AssignmentRepository {
    public function __construct(
        private PDO $pdo
    ){}

    public function findByUserId(int $id): array {
        $sql = "SELECT "
    }
}