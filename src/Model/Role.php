<?php

namespace TM\Model;

use TM\Enum\RoleName;

class Role {
    public function __construct(
        private readonly int $id,
        private readonly RoleName $name
    ){}

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
}