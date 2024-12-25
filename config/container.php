<?php
$pimpleContainer = new Pimple\Container();
$pimpleContainer['app.service.xml'] = fn($c) => new App\Service\XmlService();

$container = new Pimple\Psr11\Container($pimpleContainer);
