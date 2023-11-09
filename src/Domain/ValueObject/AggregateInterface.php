<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject;

use JsonSerializable;

interface AggregateInterface extends JsonSerializable
{
    public static function createFromArray(array $data): AggregateInterface;
}
