<?php

namespace TM\DTO;

class AuthResponse {
    public function __construct(
        private int $id,
        private int $roleId,
        private string $firstname,
        private string $lastname,
        private string $email
    ){}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'roleId' => $this->roleId,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email
        ];
    }
}