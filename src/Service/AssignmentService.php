<?php

namespace TM\Service;

use RuntimeException;
use TM\Repository\AssignmentRepository;
use TM\Repository\TaskRepository;
use TM\Repository\UserRepository;
use TM\Model\Assignment;

class AssignmentService {

    public function __construct(
        private AssignmentRepository $assignmentRepository,
        private TaskRepository $taskRepository,
        private UserRepository $userRepository,
        private AuthService $authService
    ){}

    public function assignTask(int $userId, int $taskId): Assignment {
        $this->isAdmin();

        $task = $this->taskRepository->findById($taskId);
        if($task === null)
            throw new RuntimeException("Task not found");
        $user = $this->userRepository->findById($userId);
        if($user === null)
            throw new RuntimeException("User not found");
        if($this->assignmentRepository->findByUserIdAndTaskId($userId, $taskId) !== null)
            throw new RuntimeException("Task is already assigned to this user");

        $assignment = new Assignment(
            null,
            $user->getId(),
            $task->getId()
        );

        return $this->assignmentRepository->save($assignment);
    }
    
    private function isAdmin(): void {
        if ($this->authService->getCurrentUser()->getId() !== 1)
            throw new RuntimeException("Not Allowed, Admins only");
    }
}