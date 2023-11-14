<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\StoreId;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class StoreIdMiddleware implements StoreIdMiddlewareInterface
{
    private const DEFAULT_RESPONSE_HEADER = 'X-Store-Id';
    public const  ATTRIBUTE_NAME          = 'store-id';

    protected ?int $storeId = null;

    public function __construct(
        private readonly ?string $responseHeader = self::DEFAULT_RESPONSE_HEADER
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestWithAttribute = $this->attachStoreIdToAttribute($request);

        $response = $handler->handle($requestWithAttribute);

        return $this->attachRequestIdToResponse($response);
    }

    private function attachStoreIdToAttribute(ServerRequestInterface $request): ServerRequestInterface
    {
        $this->storeId = isset($request->getAttribute('token')['sub'])
            ? (int)$request->getAttribute('token')['sub']
            : null;

        return $request->withAttribute(self::ATTRIBUTE_NAME, $this->storeId);
    }

    private function attachRequestIdToResponse(ResponseInterface $response): ResponseInterface
    {
        if (!empty($this->responseHeader) && !empty($this->storeId)) {
            return $response->withHeader($this->responseHeader, $this->storeId);
        }

        return $response;
    }

    public function getStoreId(): ?int
    {
        return $this->storeId
            ? (int)$this->storeId
            : null;
    }
}
