<?php

namespace TM\Router;

use TM\Controller\JsonResponse;

class Router {
    private array $routes;

    public function get(string $path, callable $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, callable $handler): void {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, callable $handler): void {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): JsonResponse {
        foreach ($this->routes as $route) {
            if($route['method'] !== $method)
                continue;

            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if(preg_match($pattern, $uri, $matches)){
                array_shift($matches);
                $response = call_user_func($route['handler'], ...$matches);

                return $response;
            }
        }
        
        http_response_code(404);
            return new JsonResponse(['message' => 'Route not found'], 404);
    }
}