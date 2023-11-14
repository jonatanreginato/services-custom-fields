<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\StoreId;

use Psr\Http\Server\MiddlewareInterface;

class StoreIdMiddlewareFactory
{
    public function __invoke(): MiddlewareInterface
    {
        return new StoreIdMiddleware();
    }
}
