<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Middleware;

use Nuvemshop\ApiTemplate\Infrastructure\Log\Exception\JsonProcessException;
use Monolog\Logger;
use PhpMiddleware\RequestId\RequestIdMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

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

        try {
            $token = json_encode([
                'iss' => $request->getAttribute('token')['iss'] ?? null,
                'exp' => $request->getAttribute('token')['exp'] ?? null,
                'sub' => $request->getAttribute('token')['sub'] ?? null,
                'aud' => $request->getAttribute('token')['aud'] ?? null,
                'iat' => $request->getAttribute('token')['iat'] ?? null,
            ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } catch (Throwable $e) {
            throw new JsonProcessException($e->getMessage());
        }

        $headers = $request->getHeaders();
        unset($headers['authorization']);
        $headers['authorization-token'] = $token;

        if ($path !== '/alive') {
            // $this->logger->info("$method $path HTTP/$version", [
            //     'context'    => 'http.request',
            //     'url'        => (string)$uri,
            //     'request_id' => $request->getAttribute(RequestIdMiddleware::ATTRIBUTE_NAME),
            //     'request'    => [
            //         'headers' => $headers,
            //         'body'    => $request->getBody()->getContents(),
            //     ],
            // ]);
        }

        $response = $handler->handle($request);

        if ($path !== '/alive') {
            $statusCode     = $response->getStatusCode();
            $responseLogger = [$this->logger, $statusCode < 399 ? 'info' : 'error'];
            $body           = $response->getBody();
            $contents       = ($body->isReadable() && $body->getSize() < 5000)
                ? $body->getContents()
                : 'Resposta muito longa';

            // $responseLogger("HTTP/$version $statusCode $path", [
            //     'context'    => 'http.response',
            //     'url'        => (string)$request->getUri(),
            //     'request_id' => $request->getAttribute(RequestIdMiddleware::ATTRIBUTE_NAME),
            //     'response'   => [
            //         'status_code' => $response->getStatusCode(),
            //         'body'        => $contents,
            //     ],
            // ]);
        }

        return $response;
    }
}
