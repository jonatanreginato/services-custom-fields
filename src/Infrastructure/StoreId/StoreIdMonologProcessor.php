<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\StoreId;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

final class StoreIdMonologProcessor implements ProcessorInterface
{
    private const KEY = 'store_id';

    public function __construct(
        private readonly StoreIdMiddlewareInterface $storeIdMiddleware
    ) {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra[self::KEY] = $this->storeIdMiddleware->getStoreId();

        return $record;
    }
}
