<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Traits;

use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityQueryBuilder;

trait QueryBuilderTrait
{
    protected function createBuilder(string $entityName, string $alias): void
    {
        $this->queryBuilder = (new EntityQueryBuilder($this->_em, $entityName, $alias));
    }

    protected function makeQueryBuilder(bool $withoutDeleted = false): void
    {
        $this->createBuilder($this->_entityName, $this->getAlias());

        $this->queryBuilder
            ->select($this->getAlias())
            ->from($this->_entityName, $this->getAlias());

        $this->applyFilters($withoutDeleted);
    }

    protected function clearBuilderParameters(): void
    {
        $this->filterParameters = null;
    }
}
