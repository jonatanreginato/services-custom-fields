<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Ramsey\Uuid\Uuid;

date_default_timezone_set('Etc/GMT+3');

ini_set('xdebug.mode', 'coverage');

define('RESOURCE_USAGE', (array)(getrusage() ?? []));
define('START_EXECUTION_TIME', microtime(true));
define('APP_ROOT', dirname(realpath(__DIR__)));

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

// Copy the .env file
copy(__DIR__ . '/../environment/testing.env', __DIR__ . '/.env');

// Loads environment variables from .env to getenv(), $_ENV and $_SERVER automagically.
$dotenv = Dotenv::createUnsafeMutable(APP_ROOT);
$dotenv->load();
