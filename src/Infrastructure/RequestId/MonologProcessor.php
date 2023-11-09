<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Nuvemshop\CustomFields\Infrastructure\RequestId\Exception\MissingRequestId;

final class MonologProcessor
{
    private const KEY = 'request_id';

    private RequestIdProviderInterface $requestIdProvider;

    public function __construct(RequestIdProviderInterface $requestIdProvider)
    {
        $this->requestIdProvider = $requestIdProvider;
    }

    public function __invoke(array $record): array
    {
        try {
            $requestId = $this->requestIdProvider->getRequestId();
        } catch (MissingRequestId) {
            $requestId = null;
        }

        $record['extra'][self::KEY] = $requestId;

        return $record;
    }
}
