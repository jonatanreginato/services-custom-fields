<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Generator\GeneratorInterface;
use Nuvemshop\ApiTemplate\Infrastructure\RequestId\OverridePolicy\OverridePolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestIdProviderFactory implements RequestIdProviderFactoryInterface
{
    protected GeneratorInterface $generator;
    protected OverridePolicyInterface|bool $allowOverride;
    protected string $requestHeader;

    public function __construct(
        GeneratorInterface $generator,
        OverridePolicyInterface|bool $allowOverride = true,
        string $requestHeader = RequestIdProvider::DEFAULT_REQUEST_HEADER
    ) {
        $this->generator = $generator;
        $this->allowOverride = $allowOverride;
        $this->requestHeader = $requestHeader;
    }

    public function create(ServerRequestInterface $request): RequestIdProviderInterface
    {
        return new RequestIdProvider($request, $this->generator, $this->allowOverride, $this->requestHeader);
    }
}
