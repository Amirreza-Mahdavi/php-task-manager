<?php

namespace TM\Service;

use RuntimeException;
use TM\DTO\LoginRequest;
use TM\DTO\RegisterRequest;
use TM\Repository\UserRepository;
use TM\Model\User;

class AuthService {
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function register(RegisterRequest $request): User {
        if ($this->userRepository->findByEmail($request->getEmail()) !== null)
            throw new RuntimeException("Email is already in use");

        $user = new User(
            0,
            2,
            $request->getFirstname(), 
            $request->getLastname(), 
            $request->getEmail(),
            password_hash($request->getPassword(), PASSWORD_DEFAULT)
        );

        return $this->userRepository->save($user);
    }

    public function login(LoginRequest $request): User {
        $user = $this->userRepository->findByEmail($request->getEmail());
        if ($user === null)
            throw new RuntimeException("Invalid credentials");
        if (!password_verify($request->getPassword(), $user->getPassword()))
            throw new RuntimeException("Invalid credentials");

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();

        return $user;
    }

    public function getCurrentUser(): ?User {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return $this->userRepository->findById(
            (int) $_SESSION['user_id']
        );
    }
}