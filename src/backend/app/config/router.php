<?php

use Phalcon\Mvc\Router;

/** @var Router $router */
$router = $di->getRouter(false);

$router->setDefaults(
    [
        'namespace'  => 'maze\Controllers',
        'controller' => 'index',
        'action'     => 'index',
    ]
);
$router->add(
    '/index/ajax',
    [
        'namespace'  => 'maze\Controllers',
        'controller' => 'index',
        'action'     => 'ajax',
    ]
);
$router->add(
    '/ajax',
    [
        'namespace'  => 'maze\Controllers',
        'controller' => 'index',
        'action'     => 'ajax',
    ]
);

$router->handle();
