<?php

namespace TM\Controller;

use TM\Service\AuthService;
use TM\Trait\JsonRequestTrait;
use TM\Controller\JsonResponse;
use TM\DTO\LoginRequest;
use TM\DTO\RegisterRequest;

class AuthController {
    use JsonRequestTrait;

    public function __construct(
        private AuthService $authService
    ){}

    public function register(): JsonResponse {
        $data = $this->getJsonBody();
        $request = new RegisterRequest(
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['password']
        );
        $response = $this->authService->register($request);
        
        return new JsonResponse($response, 201);
    }

    public function login(): JsonResponse {
        $data = $this->getJsonBody();
        $request = new LoginRequest(
            $data['email'],
            $data['password']
        );
        $response = $this->authService->login($request);

        return new JsonResponse($response, 200);
    }
}