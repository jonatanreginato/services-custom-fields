<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Formatter;

use DateTimeInterface;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\LogRecord;

class OpenSearchFormatter extends NormalizerFormatter
{
    public function __construct(protected string $index, protected string $type)
    {
        // OpenSearch requires an ISO 8601 format date with optional millisecond precision.
        parent::__construct(DateTimeInterface::ATOM);
    }

    public function format(LogRecord $record): array
    {
        $formattedRecord = parent::format($record);

        return $this->getDocument($formattedRecord);
    }

    public function getIndex(): string
    {
        return $this->index;
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function getDocument(array $record): array
    {
        $record['_index'] = $this->index;
        $record['_type']  = $this->type;

        return $record;
    }
}
