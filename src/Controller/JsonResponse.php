<?php

namespace TM\Controller;

class JsonResponse {
    public function __construct(
        private mixed $data,
        private int $statusCode = 200
    ){}

    public function send(): void {
        http_response_code($this->statusCode);
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}