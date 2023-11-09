<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use Psr\Http\Message\ServerRequestInterface;

interface RequestIdProviderFactoryInterface
{
    public function create(ServerRequestInterface $request): RequestIdProviderInterface;
}