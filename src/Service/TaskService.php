<?php

namespace TM\Service;

use DateTimeImmutable;
use RuntimeException;
use TM\Repository\TaskRepository;
use TM\DTO\CreateTaskRequest;
use TM\Model\Assignment;
use TM\Service\AuthService;
use TM\Model\Task;
use TM\Repository\AssignmentRepository;
use TM\Repository\UserRepository;
use TM\Model\User;

class TaskService {
    public function __construct(
        private TaskRepository $taskRepository,
        private AuthService $authService,
        private UserRepository $userRepository,
        private AssignmentRepository $assignmentRepository
    ){}

    public function addTask(CreateTaskRequest $request): Task {
        $task = new Task();

        $task->setUserId($this->checkAuthentication());
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

        $this->checkAuthorization($task->getUserId());

        $subtask = new Task();

        $subtask->setUserId($this->checkAuthentication());
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

    private function checkAuthentication(): int {
        $user = $this->authService->getCurrentUser();
        if($user === null)
            throw new RuntimeException("Authentication required");
        return $user->getId();
    }

    private function checkAuthorization(int $userId): void {
        if ($userId !== $this->authService->getCurrentUser()->getId())
            throw new RuntimeException("User not allowed to update task");
    }

    public function updateTask(int $id, CreateTaskRequest $request): Task {
        $task = $this->taskRepository->findById($id);
        if ($task === null)
            throw new RuntimeException("task not found");

        $this->checkAuthorization($task->getUserId());

        $task->setTitle($request->getTitle());
        $task->setDescription($request->getDescription());
        $task->setStatus($request->getStatus());
        $task->setPriority($request->getPriority());
        $task->setDueDate($request->getDueDate());
        $task->setUpdatedAt(new DateTimeImmutable());

        return $this->taskRepository->save($task);
    }

    public function deleteTask(int $id): void {
        $task = $this->taskRepository->findById($id);
        if ($task === null)
            throw new RuntimeException("task not found");

        $this->checkAuthorization($task->getUserId());

        if($this->assignmentRepository->findByTaskId($id) !== null)
            throw new RuntimeException("Task cannot be deleted because it has assignments");

        $this->taskRepository->delete($id);
    }
}