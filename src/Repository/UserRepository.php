<?php 

namespace TM\Repository;

use PDO;
use TM\Model\User;

class UserRepository {
    public function __construct(
        private PDO $pdo
    ){}

    public function findById(int $id): ?User {
        $sql = "SELECT id, role_id, first_name, last_name, email, password FROM users WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false)
            return null;

        return $this->mapToUser($row);
    }

    public function findAll(): array {
        $users = [];

        $sql = "SELECT id, role_id, first_name, last_name, email, password FROM users";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $users[] = $this->mapToUser($row);
        }

        return $users;
    }

    public function findByEmail(string $email): ?User {
        $sql = "SELECT id, role_id, first_name, last_name, email, password FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false)
            return null;

        return $this->mapToUser($row);
    }

    public function searchByEmail(string $email): array {
        $users = [];
        $sql = "SELECT id, role_id, first_name, last_name, email, password FROM users WHERE email LIKE :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => '%' . $email . '%']);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $users[] = $this->mapToUser($row);
        }

        return $users;
    }

    public function findByRoleId(int $roleId): array {
        $users = [];

        $sql = "SELECT id, role_id, first_name, last_name, email, password FROM users WHERE role_id = :role_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['role_id' => $roleId]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $users[] = $this->mapToUser($row);
        }

        return $users;
    }

    public function save(User $user): User {
        if ($user->getId() === 0)
            return $this->insert($user);

        return $this->update($user);
    }

    private function insert(User $user): User {
        $sql = "
        INSERT INTO users (
        role_id,
        first_name,
        last_name,
        email,
        password
        )
        VALUES (
        :role_id,
        :first_name,
        :last_name,
        :email,
        :password
        )
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'role_id' => $user->getRoleId(),
            'first_name' => $user->getFirstname(),
            'last_name' => $user->getLastname(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        $user->setId((int) $this->pdo->lastInsertId());
        return $user;
    }

    private function update(User $user): User {
        $sql = "
        UPDATE users
        SET
        first_name = :first_name,
        last_name = :last_name,
        password = :password
        WHERE id = :id
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $user->getId(),
            'first_name' => $user->getFirstname(),
            'last_name' => $user->getLastname(),
            'password' => $user->getPassword()
        ]);

        return $user;
    }

    public function delete(int $id): void {

        $sql = "DELETE FROM users WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    private function mapToUser(array $row): User {
        return new User(
            $row['id'] !== null ? (int) $row['id'] : null,
            (int) $row['role_id'],
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['password']
        );
    }
}