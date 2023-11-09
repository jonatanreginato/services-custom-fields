<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

interface RequestIdProviderInterface
{
    public function getRequestId(): string;
}
