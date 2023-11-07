<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action;

use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Repository;

readonly class CounterAction
{
    public function __construct(protected Repository $customFieldsRepository)
    {
    }

    public function __invoke(AggregateInterface $aggregate): array
    {
        return $this->customFieldsRepository->getCount();
    }
}
