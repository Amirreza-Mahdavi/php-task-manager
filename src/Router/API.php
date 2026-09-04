<?php

use TM\Controller\AssignmentController;
use TM\Controller\AuthController;
use TM\Controller\TaskController;
use TM\Router\Router;

return function (
    Router $router,
    AuthController $authController,
    TaskController $taskController,
    AssignmentController $assignmentController
): void {

    // authentication
    $router->post( '/register', [$authController, 'register']);
    $router->post('/login', [$authController, 'login']);

    // task
    $router->post('/tasks', [$taskController, 'addTask']);
    $router->post('/tasks/{id}/subtasks', [$taskController, 'addSubtask']);
    $router->put('/tasks/{id}', [$taskController, 'updateTask']);
    $router->delete('/tasks/{id}/delete', [$taskController, 'deleteTask']);

    // assignment
    $router->post('/tasks/{userId}/assign/{taskId}', [$assignmentController, 'assignTask']);
};