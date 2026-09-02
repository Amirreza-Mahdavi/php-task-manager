<?php

namespace TM\Service;

use RuntimeException;
use TM\Repository\AssignmentRepository;
use TM\Repository\TaskReposotory;
use TM\Repository\UserRepository;
use TM\Model\Assignment;

class AssignmentService {
    public function __construct(
        private AssignmentRepository $assignmentRepository,
        private TaskReposotory $taskRepository,
        private UserRepository $userRepository
    ){}

    public function assignTask(int $userId, int $taskId): Assignment {
        $task = $this->taskRepository->findById($taskId);
        if($task === null)
            throw new RuntimeException("Task not found");
        $user = $this->userRepository->findById($userId);
        if($user === null)
            throw new RuntimeException("User not found");

        $assignment = new Assignment(
            null,
            $user->getId(),
            $task->getId()
        );

        return $this->assignmentRepository->save($assignment);
    }
}