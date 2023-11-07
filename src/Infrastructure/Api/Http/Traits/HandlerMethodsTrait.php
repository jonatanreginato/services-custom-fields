<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits;

use Nuvemshop\ApiTemplate\Application\Api\Exceptions\MissingStoreIdException;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers\MediaType;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers\MediaTypeInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\Responses;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ResponsesInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\Link;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\LinkInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

trait HandlerMethodsTrait
{
    protected function getStoreId(ServerRequestInterface $request): int
    {
        $storeId = (int)($request->getAttribute('token')['sub'] ?? null);
        if (!$storeId) {
            throw new MissingStoreIdException();
        }

        return $storeId;
    }

    protected function getUuid(ServerRequestInterface $request): ?string
    {
        return $request->getAttribute('uuid');
    }

    protected function getId(ServerRequestInterface $request): mixed
    {
        return $request->getAttribute('id');
    }

    protected function defaultCreateResponse(
        EntityInterface $entity,
        UriInterface $requestUri,
        EncoderInterface $encoder
    ): ResponseInterface {
        $responses = $this->defaultCreateResponses($requestUri, $encoder);
        $fullUrl   = $this->defaultGetResourceUrl($entity, $requestUri);

        return $responses->getCreatedResponse($entity, $fullUrl);
    }

    protected function defaultCreateResponses(UriInterface $requestUri, EncoderInterface $encoder): ResponsesInterface
    {
        $encoder->withOriginalUri($requestUri);

        return new Responses(
            new MediaType(MediaTypeInterface::TYPE, MediaTypeInterface::SUB_TYPE),
            $encoder
        );
    }

    protected function defaultGetResourceUrl(EntityInterface $entity, UriInterface $requestUri): string
    {
        $selfLink  = $this->getSelfLink($entity, $requestUri);
        $urlPrefix = (string)$requestUri->withPath('')->withQuery('')->withFragment('');

        return $selfLink->getStringRepresentation($urlPrefix);
    }

    public function getSelfLink(EntityInterface $resource, UriInterface $requestUri): LinkInterface
    {
        return $this->createLink(true, $this->getSelfSubUrl($resource, $requestUri));
    }

    public function getSelfSubUrl(EntityInterface $resource, UriInterface $requestUri): string
    {
        if ($resource instanceof CustomFieldEntityInterface) {
            return $requestUri->getPath() . '/' . $resource->getUuid();
        }

        return $requestUri->getPath() . '/' . $resource->getId();
    }

    public function createLink(bool $isSubUrl, string $value): LinkInterface
    {
        return new Link($isSubUrl, $value);
    }
}
