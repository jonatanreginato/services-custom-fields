<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId\OverridePolicy;

use Psr\Http\Message\ServerRequestInterface;

interface OverridePolicyInterface
{
    public function isAllowToOverride(ServerRequestInterface $request): bool;
}
