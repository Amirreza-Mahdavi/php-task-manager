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

    public function addTask(CreateTaskRequest $request): Task {
        $task = new Task();

        $task->setUserId($this->authService->getCurrentUser()->getId());
        $task->setTitle($request->getTitle());
        $task->setDescription($request->getDescription());
        $task->setStatus($request->getStatus());
        $task->setPriority($request->getPriority());
        $task->setDueDate($request->getDueDate());
        $task->setCreatedAt(new DateTimeImmutable());
        $task->setUpdatedAt(new DateTimeImmutable());

        return $this->taskRepository->save($task);
    }

    public function addSubtask(int $taskId, CreateTaskRequest $request): Task {
        $task = $this->taskRepository->findById($taskId);
        if ($task === null)
            throw new RuntimeException("task not found");

        $subtask = new Task();

        $task->setUserId($this->authService->getCurrentUser()->getId());
        $subtask->setTaskId($task->getId());
        $subtask->setTitle($request->getTitle());
        $subtask->setDescription($request->getDescription());
        $subtask->setStatus($request->getStatus());
        $subtask->setPriority($request->getPriority());
        $subtask->setDueDate($request->getDueDate());
        $subtask->setCreatedAt(new DateTimeImmutable());
        $subtask->setUpdatedAt(new DateTimeImmutable());

        return $this->taskRepository->save($subtask);
    }

    public function updateTask(int $id, CreateTaskRequest $request): Task {
        $task = $this->taskRepository->findById($id);
        if ($task === null)
            throw new RuntimeException("task not found");

        $task->setTitle($request->getTitle());
        $task->setDescription($request->getDescription());
        $task->setStatus($request->getStatus());
        $task->setPriority($request->getPriority());
        $task->setDueDate($request->getDueDate());
        $task->setUpdatedAt(new DateTimeImmutable());

        return $this->taskRepository->save($task);
    }

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