<?php

namespace TM\Trait;

use RuntimeException;
use TM\Service\AuthService;

trait Authorization {
    public function __construct(
        private AuthService $authService
    ){}

    public function isAdmin(): void {
        if ($$this->authService->getCurrentUser()->getId() !== 1)
            throw new RuntimeException("Not Allowed, Admins only");
    }
}