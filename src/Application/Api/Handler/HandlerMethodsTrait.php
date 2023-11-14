<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\MissingStoreIdException;
use Psr\Http\Message\ServerRequestInterface;

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
}
