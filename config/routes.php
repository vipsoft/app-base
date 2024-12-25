<?php
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) use ($container) {
    $r->addRoute('GET', '/', function () use ($container) {
        $controller = new App\Controller\IndexController($container);

        return $controller->defaultAction();
    });

    $r->addRoute('OPTONS', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->optionsAction();
    });

    $r->addRoute('HEAD', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->headAction();
    });

    $r->addRoute('POST', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->postAction();
    });

    $r->addRoute('GET', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->getAction();
    });

    $r->addRoute('PUT', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->putAction();
    });

    $r->addRoute('DELETE', '/api/1.0/', function () use ($container) {
        $controller = new App\Controller\ApiController($container);

        return $controller->deleteAction();
    });
});
