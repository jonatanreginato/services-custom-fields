<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Nuvemshop\CustomFields\Infrastructure\RequestId\Generator\GeneratorInterface;

final class RequestIdProvider implements RequestIdProviderInterface
{
    protected ?string $requestId = null;

    public function __construct(
        protected readonly GeneratorInterface $generator
    ) {
    }

    public function getRequestId(): string
    {
        if ($this->requestId !== null) {
            return $this->requestId;
        }

        $this->requestId = $this->generator->generateRequestId();

        return $this->requestId;
    }
}
