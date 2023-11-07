<?php

declare(strict_types=1);

try {
    function get_files(string $path = './public'): array
    {
        $files            = [];
        $publicFiles      = scandir($path);
        $ignoreFiles      = ['.', '..'];
        $ignoreExtensions = ['php'];

        foreach ($publicFiles as $file) {
            $pathFile = $path . '/' . $file;
            $ext      = pathinfo($pathFile, PATHINFO_EXTENSION);

            if (in_array($file, $ignoreFiles, true) || in_array($ext, $ignoreExtensions, true)) {
                continue;
            }

            if (!is_dir($pathFile)) {
                $files[] = format_file($pathFile);
                continue;
            }

            foreach (get_files($pathFile) as $item) {
                $files[] = format_file($item);
            }
        }

        return $files;
    }

    function format_file(string $file): string
    {
        return str_replace('./public', '', $file);
    }

    $mime_types = [
        'css'  => 'text/css',
        'csv'  => 'text/csv',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'png'  => 'image/png',
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'gif'  => 'image/gif',
        'bmp'  => 'image/bmp',
        'ico'  => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif'  => 'image/tiff',
        'svg'  => 'image/svg+xml',
        'zip'  => 'application/zip',
        'rar'  => 'application/x-rar-compressed',
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'rtf'  => 'application/rtf',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.ms-excel',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'odt'  => 'application/vnd.oasis.opendocument.text',
        'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
    ];

    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if ($uri === '/alive') {
        http_response_code(200);
        exit("<h1>php-restful-api-template says: I'm alive!<h1>");
    }

    $www_root = '/var/www/public';
    $assets   = get_files();

    foreach ($assets as $index => $asset) {
        if ($_SERVER['REQUEST_URI'] === $asset) {
            if (!file_exists("$www_root/$asset")) {
                http_response_code(404);
                exit("asset $www_root/$asset was not found!");
            }

            $extension = explode('.', $asset);
            $ext       = strtolower(end($extension));

            if (array_key_exists($ext, $mime_types)) {
                header('Content-Type: ' . $mime_types[$ext]);
            }

            http_response_code(200);
            exit(file_get_contents("$www_root/$asset"));
        }
    }
} catch (Throwable $e) {
    if (($_SERVER['ENVIRONMENT_NAME'] === 'development') || ($_SERVER['ENVIRONMENT_NAME'] === 'staging')) {
        echo $e->getMessage();
        echo $e->getCode();
        exit(1);
    }
    http_response_code($e->getCode());
    exit('Um erro inesperado ocorreu! Lamentamos pelo inconveniente!');
}
