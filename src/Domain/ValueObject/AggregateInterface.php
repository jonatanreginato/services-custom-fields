<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\ValueObject;

use JsonSerializable;

interface AggregateInterface extends JsonSerializable
{
    public static function createFromArray(array $data): AggregateInterface;
}
