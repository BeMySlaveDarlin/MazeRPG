<?php

$loader = new \Phalcon\Loader();

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
        "Bemyslavedarlin"  => $config->application->libraryDir."bemyslavedarlin/",
    ]
);

$loader->register();
