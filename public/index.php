<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

date_default_timezone_set('Etc/GMT+3');

define('RESOURCE_USAGE', (array)(getrusage() ?? []));
define('START_EXECUTION_TIME', microtime(true));
define('APP_ROOT', dirname(realpath(__DIR__)));

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// This makes our life easier when dealing with paths. Everything is relative to the application root now.
chdir(dirname(realpath(__DIR__)));

// Setup auto-loading
require 'vendor/autoload.php';

// Generate and define a RFC 4122 version 4 universally unique identifiers (UUID).
try {
    define('REQUEST_ID', Uuid::uuid4());
} catch (Exception $e) {
    echo $e->getCode() . ':' . $e->getMessage();
}

// Loads environment variables from .env to getenv(), $_ENV and $_SERVER automagically.
$dotenv = Dotenv::createUnsafeImmutable(APP_ROOT);
$dotenv->load();

require 'public/devops_php_serving_assets.php';
require 'public/devops_php_debug.php';

// Self-called anonymous function that creates its own scope and keep the global namespace clean.
(static function () {
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';
    /** @var Application $app */
    $app     = $container->get(Application::class);
    $factory = $container->get(MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing configuration statements
    (require 'config/pipeline.php')($app);
    (require 'config/routes.php')($app);

    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_USER_DEPRECATED);

    $app->run();
})();
