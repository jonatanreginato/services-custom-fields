<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\Persistence\ObjectRepository;

interface Repository extends ObjectRepository
{
    public function setFilterParameters(iterable $filterParameters): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
