<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

use Phalcon\Config;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new Config(
    [
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'service_db_mysql',
            'port' => 33600,
            'username' => 'root',
            'password' => 'password',
            'dbname' => 'maze',
            'charset' => 'utf8',
        ],
        'application' => [
            'appDir' => APP_PATH . '/',
            'controllersDir' => APP_PATH . '/Controllers/',
            'modelsDir' => APP_PATH . '/Models/',
            'migrationsDir' => APP_PATH . '/Migrations/',
            'viewsDir' => APP_PATH . '/Views/',
            'pluginsDir' => APP_PATH . '/Plugins/',
            'libraryDir' => APP_PATH . '/Library/',
            'cacheDir' => BASE_PATH . '/Cache/',

            // This allows the baseUri to be understand project paths that are not in the root directory
            // of the webpspace.  This will break if the public/index.php entry point is moved or
            // possibly if the web server rewrite rules are changed. This can also be set to a static path.
            'baseUri' => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        ],
    ]
);
