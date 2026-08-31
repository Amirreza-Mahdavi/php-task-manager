<?php

namespace TM\DTO;

class RegisterRequest {
    public function __construct(
        private string $firstname,
        private string $lastname,
        private string $email,
        private string $password 
    ){}

    public function getEmail(){
        return $this->email;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getLastname(){
        return $this->lastname;
    }
    public function getPassword(){
        return $this->password;
    }
}