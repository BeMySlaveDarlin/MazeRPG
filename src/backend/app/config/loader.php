<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->migrationsDir,
        $config->application->libraryDir,
        $config->application->pluginsDir,
    ]
);

$loader->registerNamespaces(
    [
        "Bemyslavedarlin\Helpers" => $config->application->libraryDir . "bemyslavedarlin/helpers",
        "Bemyslavedarlin\Traits"  => $config->application->libraryDir . "bemyslavedarlin/traits",
    ]
);

$loader->register();
