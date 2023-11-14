<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddleware implements RequestIdMiddlewareInterface
{
    private const DEFAULT_RESPONSE_HEADER = 'X-Request-Id';
    public const  ATTRIBUTE_NAME          = 'request-id';

    protected ?string $requestId = null;

    public function __construct(
        private readonly RequestIdProviderInterface $requestIdProvider,
        private readonly ?string $responseHeader = self::DEFAULT_RESPONSE_HEADER
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestWithAttribute = $this->attachRequestIdToAttribute($request);

        $response = $handler->handle($requestWithAttribute);

        return $this->attachRequestIdToResponse($response);
    }

    private function attachRequestIdToAttribute(ServerRequestInterface $request): ServerRequestInterface
    {
        $this->requestId = $this->requestIdProvider->getRequestId();

        return $request->withAttribute(self::ATTRIBUTE_NAME, $this->requestId);
    }

    private function attachRequestIdToResponse(ResponseInterface $response): ResponseInterface
    {
        if (!empty($this->responseHeader) && !empty($this->requestId)) {
            return $response->withHeader($this->responseHeader, $this->requestId);
        }

        return $response;
    }
}
