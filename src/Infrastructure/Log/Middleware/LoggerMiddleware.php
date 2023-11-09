<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Middleware;

use Monolog\Logger;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoggerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly Logger $logger)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri     = $request->getUri();
        $path    = $uri->getPath();
        $method  = $request->getMethod();
        $version = $request->getProtocolVersion();

        $token = [
            'iss' => $request->getAttribute('token')['iss'] ?? null,
            'exp' => $request->getAttribute('token')['exp'] ?? null,
            'sub' => $request->getAttribute('token')['sub'] ?? null,
            'aud' => $request->getAttribute('token')['aud'] ?? null,
            'iat' => $request->getAttribute('token')['iat'] ?? null,
        ];

        $headers = $request->getHeaders();
        unset($headers['authorization']);
        $headers['authorization-token'] = $token;

        if ($path !== '/alive') {
            $this->logger->info("$method $path HTTP/$version", [
                'context'    => 'http.request',
                'url'        => (string)$uri,
                'store_id'   => $request->getAttribute('token')['sub'] ?? null,
                'request_id' => $request->getAttribute(RequestIdMiddleware::ATTRIBUTE_NAME),
                'request'    => [
                    'headers' => $headers,
                    'body'    => json_decode((string)$request->getBody(), true),
                ],
            ]);
        }

        $response = $handler->handle($request);

        if ($path !== '/alive') {
            $statusCode     = $response->getStatusCode();
            $responseLogger = [$this->logger, $statusCode < 399 ? 'info' : 'error'];
            $contents       = json_decode((string)$request->getBody(), true);

            $responseLogger("HTTP/$version $statusCode $path", [
                'context'    => 'http.response',
                'url'        => (string)$request->getUri(),
                'store_id'   => $request->getAttribute('token')['sub'] ?? null,
                'request_id' => $request->getAttribute(RequestIdMiddleware::ATTRIBUTE_NAME),
                'response'   => [
                    'status_code' => $response->getStatusCode(),
                    'body'        => $contents,
                ],
            ]);
        }

        return $response;
    }
}
