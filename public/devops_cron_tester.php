<?php

declare(strict_types=1);

$environment_name = $_SERVER['ENVIRONMENT_NAME'] ?? 'development';
$app_name         = ($_SERVER['APPNAME']) ?? '';
$debug_mode       = ($_SERVER['DEBUG_MODE']) ?? false;
$service          = 'cron';

if ($debug_mode) {
    ini_set('ignore_repeated_errors', 'On');
    ini_set('html_errors', 'On');
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
}

try {
    echo '(╯°□°)╯︵ ┻━┻';
    echo PHP_EOL;
    echo $app_name . PHP_EOL;
    echo "iniciando teste de $service" . PHP_EOL;
    foreach (range(0, 100) as $number) {
        echo "$service: $number" . PHP_EOL;
    }
    echo 'PHP:' . PHP_VERSION . PHP_EOL;
    echo 'finalizando' . PHP_EOL;
    echo PHP_EOL;
    echo '(☞ ͡° ͜ʖ ͡°)☞ SPASIBO TOVARISHCH MENEDZHER';
    echo PHP_EOL;
    sleep(60);
} catch (Throwable $e) {
    echo PHP_EOL;
    echo $e->getMessage();
    echo PHP_EOL;
    echo $e->getCode();
    echo PHP_EOL;
}
