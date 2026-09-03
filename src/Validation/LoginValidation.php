<?php

namespace TM\Validation;

use TM\Exception\ValidationException;

class LoginValidation {
    public function validate(array $data): void {
        if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            throw new ValidationException("Invalid Email");
        if(empty($data['password']) || strlen($data['password']) < 7)
            throw new ValidationException("Password is required and must be at least 7 characters");
    }
}