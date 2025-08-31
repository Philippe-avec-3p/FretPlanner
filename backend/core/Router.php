<?php
// backend/core/Router.php

class Router {
    private $routes = [];
    private $middlewares = [];

    public function get($path, $callback, $middlewares = []) {
        $this->addRoute('GET', $path, $callback, $middlewares);
    }

    public function post($path, $callback, $middlewares = []) {
        $this->addRoute('POST', $path, $callback, $middlewares);
    }

    private function addRoute($method, $path, $callback, $middlewares) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public function resolve() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Enlever le chemin de base
        $basePath = '/FretPlanner';
        if (strpos($requestPath, $basePath) === 0) {
            $requestPath = substr($requestPath, strlen($basePath));
        }

        // Si vide, mettre "/"
        if (empty($requestPath) || $requestPath === '/') {
            $requestPath = '/';
        }

        // Chercher la route
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {

                // Exécuter les middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareClass = new $middleware();
                    if (!$middlewareClass->handle()) {
                        return;
                    }
                }

                // Exécuter le callback
                if (is_array($route['callback'])) {
                    $controller = new $route['callback'][0]();
                    $method = $route['callback'][1];
                    return $controller->$method();
                } else {
                    return call_user_func($route['callback']);
                }
            }
        }

        // 404 - Route non trouvée - AVEC DEBUG
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        echo "<p><strong>Route demandée :</strong> " . htmlspecialchars($requestPath) . "</p>";
        echo "<p><strong>URI complète :</strong> " . htmlspecialchars($_SERVER['REQUEST_URI']) . "</p>";
        echo "<p><strong>Méthode :</strong> " . htmlspecialchars($requestMethod) . "</p>";

        // Debug: afficher les routes disponibles
        echo "<h2>Routes disponibles dans le routeur :</h2><ul>";
        foreach ($this->routes as $route) {
            echo "<li><strong>{$route['method']}</strong> {$route['path']}</li>";
        }
        echo "</ul>";

        echo "<p><a href='/FretPlanner/'>Retour à l'accueil</a></p>";
    }

    private function matchPath($routePath, $requestPath) {
        return $routePath === $requestPath;
    }

    public function redirect($path) {
        $config = require __DIR__ . '/../config/config.php';
        $url = $config['app']['url'] . $path;
        header("Location: $url");
        exit();
    }
}