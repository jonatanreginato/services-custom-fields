<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Psr\Http\Message\ServerRequestInterface;

interface RequestIdProviderFactoryInterface
{
    public function create(ServerRequestInterface $request): RequestIdProviderInterface;
}
