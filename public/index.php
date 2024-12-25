<?php
/**
 * @copyright 2022 Anthon Pang
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/container.php';
require_once __DIR__ . '/../config/routes.php';

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== ($pos = strpos($uri, '?'))) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // 404 Not Found
        $controller = new App\Controller\NotFoundController($container);

        return $controller->defaultAction();

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // 405 Method Not Allowed
        $allowedMethods = $routeInfo[1];
        $controller = new App\Controller\MethodNotAllowedController($container, $allowedMethods);

        return $controller->defaultAction();

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        return call_user_func($handler, $vars);
}
