<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\StoreId;

use Psr\Http\Server\MiddlewareInterface;

interface StoreIdMiddlewareInterface extends MiddlewareInterface
{
    public function getStoreId(): ?int;
}
