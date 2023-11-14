<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Middleware;

use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoggerMiddleware implements LoggerMiddlewareInterface
{
    public function __construct(private readonly Logger $logger)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path    = $request->getUri()->getPath();
        $version = $request->getProtocolVersion();

        $token = [
            'subject'    => $request->getAttribute('token')['sub'] ?? null,
            'issuer'     => $request->getAttribute('token')['iss'] ?? null,
            'expiration' => $request->getAttribute('token')['exp'] ?? null,
            'issued_at'  => $request->getAttribute('token')['iat'] ?? null,
            'audience'   => $request->getAttribute('token')['aud'] ?? null,
        ];

        $headers = $request->getHeaders();
        unset($headers['authorization']);
        $headers['authorization-token'] = $token;

        if ($path !== '/alive') {
            $this->logger->info("{$request->getMethod()} $path HTTP/$version", [
                'headers' => $headers,
                'body'    => json_decode((string)$request->getBody(), true),
            ]);
        }

        $response = $handler->handle($request);

        if ($path !== '/alive') {
            $statusCode     = $response->getStatusCode();
            $responseLogger = [$this->logger, $statusCode < 399 ? 'info' : 'error'];

            $responseLogger("HTTP/$version $statusCode $path", [
                'status_code' => $response->getStatusCode(),
                'headers'     => $response->getHeaders(),
                'body'        => json_decode((string)$response->getBody(), true),
            ]);
        }

        return $response;
    }
}
