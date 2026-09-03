<?php

namespace TM\DTO;

class RegisterRequest {
    public function __construct(
        private string $firstname,
        private string $lastname,
        private string $email,
        private string $password 
    ){}

    public function getEmail(): string {
        return $this->email;
    }
    public function getFirstname(): string {
        return $this->firstname;
    }
    public function getLastname(): string {
        return $this->lastname;
    }
    public function getPassword(): string {
        return $this->password;
    }
}