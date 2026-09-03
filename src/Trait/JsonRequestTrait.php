<?php 

namespace TM\Trait;

use RuntimeException;

trait JsonRequestTrait {
    public function getJsonBody(): array {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!is_array($data))
            throw new RuntimeException("Invalid JSON");

        return $data;
    }
}