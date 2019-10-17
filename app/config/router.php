<?php

$router = $di->getRouter(false);

$router->setDefaults(
    [
        "controller" => "index",
        "action"     => "index",
    ]
);
$router->add(
    "/index/ajax",
    [
        "controller" => "index",
        "action"     => "ajax",
    ]
);
$router->add(
    "/ajax",
    [
        "controller" => "index",
        "action"     => "ajax",
    ]
);

$router->handle();
