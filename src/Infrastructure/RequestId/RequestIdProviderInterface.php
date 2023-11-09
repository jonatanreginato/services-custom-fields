<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

interface RequestIdProviderInterface
{
    public function getRequestId(): string;
}
