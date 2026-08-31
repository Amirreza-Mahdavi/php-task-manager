<?php

namespace TM\Service;

use DateTimeImmutable;
use RuntimeException;
use TM\Repository\TaskReposotory;
use TM\DTO\CreateTaskRequest;
use TM\Model\Assignment;
use TM\Service\AuthService;
use TM\Model\Task;
use TM\Repository\AssignmentRepository;
use TM\Repository\UserRepository;

class TaskService {
    public function __construct(
        private TaskReposotory $taskRepository,
        private AuthService $authService,
        private UserRepository $userRepository,
        private AssignmentRepository $assignmentRepository
    ){}

    public function addTask(CreateTaskRequest $request): void {
        $task = new Task(
            0,
            null,
            $this->authService->getCurrentUser()->getId(),
            $request->getTitle(),
            $request->getDescription(),
            $request->getStatus(),
            $request->getPriority(),
            $request->getDueDate(),
            new DateTimeImmutable(),
            new DateTimeImmutable()
        );

        $this->taskRepository->save($task);
    }

    public function addSubtask(int $taskId, CreateTaskRequest $request): void {
        $task = $this->taskRepository->findById($taskId);
        if ($task === null)
            throw new RuntimeException("task not found");

        $subtask = new Task(
            0,
            $taskId,
            $this->authService->getCurrentUser()->getId(),
            $request->getTitle(),
            $request->getDescription(),
            $request->getStatus(),
            $request->getPriority(),
            $request->getDueDate(),
            new DateTimeImmutable(),
            new DateTimeImmutable()
        );

        $this->taskRepository->save($subtask);
    }

    public function assignTask(int $userId, int $taskId): void {
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

        $this->assignmentRepository->save($assignment);
    }
}