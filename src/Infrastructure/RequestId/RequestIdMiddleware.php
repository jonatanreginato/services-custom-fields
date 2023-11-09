<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Exception\NotGenerated;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddleware implements RequestIdProviderInterface, MiddlewareInterface
{
    private const DEFAULT_RESPONSE_HEADER = 'X-Request-Id';
    public const ATTRIBUTE_NAME          = 'request-id';

    protected RequestIdProviderFactoryInterface $requestIdProviderFactory;

    protected ?string $requestId = null;

    protected ?string $responseHeader;

    public function __construct(
        RequestIdProviderFactoryInterface $requestIdProviderFactory,
        ?string $responseHeader = self::DEFAULT_RESPONSE_HEADER
    ) {
        $this->requestIdProviderFactory = $requestIdProviderFactory;
        $this->responseHeader = $responseHeader;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestWithAttribute = $this->attachRequestIdToAttribute($request);

        $response = $handler->handle($requestWithAttribute);

        return $this->attachRequestIdToResponse($response);
    }

    private function attachRequestIdToAttribute(ServerRequestInterface $request): ServerRequestInterface
    {
        $requestIdProvider = $this->requestIdProviderFactory->create($request);
        $this->requestId = $requestIdProvider->getRequestId();

        return $request->withAttribute(self::ATTRIBUTE_NAME, $this->requestId);
    }

    private function attachRequestIdToResponse(ResponseInterface $response): ResponseInterface
    {
        if (is_string($this->responseHeader) && !empty($this->responseHeader)) {
            return $response->withHeader($this->responseHeader, $this->requestId);
        }

        return $response;
    }

    public function getRequestId(): string
    {
        if (empty($this->requestId)) {
            throw new NotGenerated('Request id is not generated yet');
        }

        return $this->requestId;
    }
}
