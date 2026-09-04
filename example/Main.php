<?php

use TM\Router\Router;
use TM\Repository\TaskRepository;
use TM\Repository\UserRepository;
use TM\Repository\AssignmentRepository;
use TM\Service\TaskService;
use TM\Service\AuthService;
use TM\Service\AssignmentService;
use TM\Controller\TaskController;
use TM\Controller\AuthController;
use TM\Controller\AssignmentController;
use TM\Validation\TaskValidation;
use TM\Validation\RegisterValidation;
use TM\Validation\LoginValidation;
use TM\Exception\ValidationException;
use TM\Controller\JsonResponse;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$pdo = require __DIR__ . '/../db.php';

$router = new Router();

$taskRepository = new TaskRepository($pdo);
$userRepository = new UserRepository($pdo);
$assignmentRepository = new AssignmentRepository($pdo);

$authService = new AuthService($userRepository);
$taskService = new TaskService($taskRepository, $authService, $userRepository, $assignmentRepository);
$assignmentService = new AssignmentService($assignmentRepository, $taskRepository, $userRepository, $authService);

$taskController = new TaskController($taskService, new TaskValidation());
$authController = new AuthController($authService, new RegisterValidation(), new LoginValidation());
$assignmentController = new AssignmentController($assignmentService);

$routes = require __DIR__ . '/../src/Router/API.php';

$routes(
    $router,
    $authController,
    $taskController,
    $assignmentController
);

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

try {
    $response = $router->dispatch(
        $method,
        $uri
    );
} 
catch (ValidationException $e) {
    $response = new JsonResponse(['message' => $e->getMessage()], 400);
} 
catch (RuntimeException $e) {
    $message = $e->getMessage();
    $status = match (true) {
        str_contains($message, 'not found') => 404,
        str_contains($message, 'Authentication required') => 401,
        str_contains($message, 'Not Allowed') || str_contains($message, 'not allowed') => 403,
        default => 400,
    };

    $response = new JsonResponse(['message' => $message], $status);
} 
catch (\Throwable $e) {
    error_log($e->getMessage());
    $response = new JsonResponse(['message' => 'Internal server error'], 500);
}

$response->send();
