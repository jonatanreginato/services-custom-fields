<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Types;

use DateTimeZone;
use Nuvemshop\ApiTemplate\Infrastructure\Exception\InvalidDateTimeException;
use Throwable;

final class DateTime extends \DateTime
{
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        try {
            parent::__construct($time, $timezone);
            $this->setTimezone($timezone ?: new DateTimeZone('America/Sao_Paulo'));
        } catch (Throwable) {
            throw new InvalidDateTimeException('A data informada é inválida', 422);
        }
    }

    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function isLessThanCurrentDatetime(): bool
    {
        return $this->getTimestamp() <= (new DateTime())->getTimestamp();
    }

    public function isGreaterThanCurrentDatetime(): bool
    {
        return $this->getTimestamp() >= (new DateTime())->getTimestamp();
    }
}
