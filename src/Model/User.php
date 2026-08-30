<?php

namespace TM\Model;

class User {
    public function __construct(
        private readonly int $id,
        private readonly int $roleId,
        private string $firstname,
        private string $lastname,
        private readonly string $email,
        private string $password
    ){}

    public function getId(){
        return $this->id;
    }
    public function getRoleId(){
        return $this->roleId;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getLastname(){
        return $this->lastname;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
}