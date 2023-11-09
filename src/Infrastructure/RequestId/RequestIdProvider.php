<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Exception\InvalidRequestId;
use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Exception\MissingRequestId;
use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Generator\GeneratorInterface;
use Nuvemshop\ApiTemplate\Infrastructure\RequestId\OverridePolicy\OverridePolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestIdProvider implements RequestIdProviderInterface
{
    public const DEFAULT_REQUEST_HEADER = 'X-Request-Id';

    protected ServerRequestInterface $request;

    protected GeneratorInterface $generator;

    protected OverridePolicyInterface|bool $allowOverride;

    protected ?string $requestId = null;

    protected string $requestHeader;

    public function __construct(
        ServerRequestInterface $request,
        GeneratorInterface $generator,
        OverridePolicyInterface|bool $allowOverride = true,
        string $requestHeader = self::DEFAULT_REQUEST_HEADER
    ) {
        $this->request       = $request;
        $this->generator     = $generator;
        $this->allowOverride = $allowOverride;
        $this->requestHeader = $requestHeader;
    }

    public function getRequestId(): string
    {
        if ($this->requestId !== null) {
            return $this->requestId;
        }

        if ($this->isPossibleToGetFromRequest($this->request)) {
            $requestId = $this->request->getHeaderLine($this->requestHeader);

            if (empty($requestId)) {
                throw new MissingRequestId(sprintf('Missing request id in "%s" request header', $this->requestHeader));
            }
        } else {
            $requestId = $this->generator->generateRequestId();

            if (empty($requestId)) {
                throw new InvalidRequestId('Generator return empty value');
            }
            if (!is_string($requestId)) {
                throw new InvalidRequestId('Request id is not a string');
            }
        }
        $this->requestId = $requestId;

        return $requestId;
    }

    protected function isPossibleToGetFromRequest(ServerRequestInterface $request): bool
    {
        if ($this->allowOverride instanceof OverridePolicyInterface) {
            $allowOverride = $this->allowOverride->isAllowToOverride($request);
        } else {
            $allowOverride = $this->allowOverride;
        }

        return $allowOverride === true && $request->hasHeader($this->requestHeader);
    }
}
