<?php

namespace TM\Controller;

use TM\Service\AuthService;
use TM\Trait\JsonRequestTrait;
use TM\Controller\JsonResponse;
use TM\DTO\AuthResponse;
use TM\DTO\LoginRequest;
use TM\DTO\RegisterRequest;
use TM\Model\User;

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
        $user = $this->authService->register($request);
        $response = $this->mapToResponse($user);
        
        return new JsonResponse($response->toArray(), 201);
    }

    public function login(): JsonResponse {
        $data = $this->getJsonBody();
        $request = new LoginRequest(
            $data['email'],
            $data['password']
        );
        $user = $this->authService->login($request);
        $response = $this->mapToResponse($user);

        return new JsonResponse($response->toArray(), 200);
    }

    private function mapToResponse(User $user): AuthResponse {
        return new AuthResponse(
            $user->getId(),
            $user->getRoleId(),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail()
        );
    }

}