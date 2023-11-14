<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

final class RequestIdMonologProcessor implements ProcessorInterface
{
    private const KEY = 'request_id';

    public function __construct(
        private readonly RequestIdProviderInterface $requestIdProvider
    ) {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra[self::KEY] = $this->requestIdProvider->getRequestId();

        return $record;
    }
}
