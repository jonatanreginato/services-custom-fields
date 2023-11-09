<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action;

use Nuvemshop\CustomFields\Domain\Repository;

// phpcs:ignoreFile -- this is a readonly class
readonly class CounterAction
{
    public function __construct(
        protected Repository\Order\CustomFieldRepositoryInterface $orderFieldRepository
    ) {
    }

    public function __invoke(int $storeId): array
    {
        return array_merge(
            $this->orderFieldRepository->getCountByOwner($storeId)
        );
    }
}
