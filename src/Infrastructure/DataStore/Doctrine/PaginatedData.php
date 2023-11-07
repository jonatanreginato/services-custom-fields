<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

class PaginatedData implements PaginatedDataInterface
{
    public function __construct(public readonly array $data)
    {
    }

    public function getData(): array
    {
        return $this->data;
    }
}
