<?php

namespace TM\Controller;

use TM\DTO\AssignmentResponse;
use TM\Service\AssignmentService;
use TM\Trait\JsonRequestTrait;

class AssignmentController {
    use JsonRequestTrait;

    public function __construct(
        private AssignmentService $assignmentService
    ){}

    public function assignTask(int $userId, int $taskId): JsonResponse {
        $assignment = $this->assignmentService->assignTask($userId, $taskId);
        $response = new AssignmentResponse(
            $assignment->getId(),
            $assignment->getUserId(),
            $assignment->getTaskId()
        );

        return New JsonResponse($response->toArray(), 201);
    }
}