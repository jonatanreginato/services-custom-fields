<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener;

use Monolog;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

abstract class AbstractListener
{
    public function __construct(private readonly Monolog\Logger $logger)
    {
    }

    public function __invoke(Throwable $error, ServerRequestInterface $request, ResponseInterface $response): void
    {
        $uri        = $request->getUri();
        $path       = $uri->getPath();
        $version    = $request->getProtocolVersion();
        $statusCode = $response->getStatusCode();
        $body       = $response->getBody();
        $contents   = ($body->isReadable() && $body->getSize() < 5000)
            ? $body->getContents()
            : 'Resposta muito longa';

        $this->logger->error("HTTP/$version $statusCode $path", [
            'url'           => (string)$request->getUri(),
            'status_code'   => $response->getStatusCode(),
            'error_message' => $error->getMessage(),
            'request_id'    => $request->getAttribute(RequestIdMiddleware::ATTRIBUTE_NAME),
            'response_body' => $contents,
        ]);
    }
}
