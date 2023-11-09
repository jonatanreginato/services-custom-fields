<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

interface PaginatedDataInterface
{
    public function getData(): array;
}
