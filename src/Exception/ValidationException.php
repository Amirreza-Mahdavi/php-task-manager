<?php

namespace TM\Exception;

use RuntimeException;

class ValidationException extends RuntimeException {
    public function __construct(string $maessage){
        parent::__construct($maessage);
    }
}