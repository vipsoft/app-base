<?php
/**
 * @copyright 2022 Anthon Pang
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        $controller = new App\Controller\IndexController();

        return $controller->defaultAction();
    });

    $r->addRoute('OPTONS', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->optionsAction();
    });

    $r->addRoute('HEAD', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->headAction();
    });

    $r->addRoute('POST', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->postAction();
    });

    $r->addRoute('GET', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->getAction();
    });

    $r->addRoute('PUT', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->putAction();
    });

    $r->addRoute('DELETE', '/api/1.0/', function () {
        $controller = new App\Controller\ApiController();

        return $controller->deleteAction();
    });
});

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
        $controller = new App\Controller\NotFoundController();

        return $controller->defaultAction();

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // 405 Method Not Allowed
        $allowedMethods = $routeInfo[1];
        $controller = new App\Controller\MethodNotAllowedController($allowedMethods);

        return $controller->defaultAction();

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        return call_user_func($handler, $vars);
}
