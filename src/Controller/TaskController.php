<?php

namespace TM\Controller;

use TM\Trait\JsonRequestTrait;
use TM\DTO\CreateTaskRequest;
use TM\Service\TaskService;
use TM\DTO\TaskResponse;
use TM\Model\Task;
use TM\Controller\JsonResponse;

class TaskController {
    use JsonRequestTrait;

    public function __construct(
        private TaskService $taskService
    ){}

    public function addTask(): JsonResponse {
        $data = $this->getJsonBody();
        $task = $this->taskService->addTask($this->mapToRequest($data));
        $response = $this->mapToResponse($task);

        return new JsonResponse($response->toArray(), 201);
    }

    public function addSubtask(int $taskId): JsonResponse {
        $data = $this->getJsonBody();
        $subtask = $this->taskService->addSubtask($taskId, $this->mapToRequest($data));
        $response = $this->mapToResponse($subtask);

        return new JsonResponse($response->toArray(), 201);
    }

    public function updateTask(int $id): JsonResponse {
        $data = $this->getJsonBody();
        $task = $this->taskService->updateTask($id, $this->mapToRequest($data));
        $response = $this->mapToResponse($task);

        return new JsonResponse($response->toArray());
    }

    private function mapToRequest(array $data): CreateTaskRequest {
        return new CreateTaskRequest(
            $data['title'],
            $data['description'],
            $data['status'],
            $data['priority'],
            $data['dueDate']
        );
    }

    private function mapToResponse(Task $task): TaskResponse {
        return new TaskResponse(
            $task->getTitle(),
            $task->getDescription(),
            $task->getStatus(),
            $task->getPriority(),
            $task->getDueDate(),
            $task->getCreatedAt(),
            $task->getUpdatedAt()
        );
    }
}