<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Traits;

use Nuvemshop\CustomFields\Application\Api\Query\FilterParameterInterface;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;

trait FilterTrait
{
    protected function applyFilters($withoutDeleted = false): Repository
    {
        if (!empty($this->filterParameters)) {
            $this->queryBuilder->addFilters($this->filterParameters);
        }

        if ($withoutDeleted) {
            $this->queryBuilder->addFilters(
                [
                    'deletedAt' => [
                        FilterParameterInterface::OPERATION_IS_NULL => []
                    ]
                ]
            );
        }

        return $this;
    }
}
