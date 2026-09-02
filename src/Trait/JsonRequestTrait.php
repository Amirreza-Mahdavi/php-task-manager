<?php 

namespace TM\Trait;

trait JsonRequestTrait {
    public function getJsonBody(): array {
        return json_decode(file_get_contents('php://input'), true);
    }
}