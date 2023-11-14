<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\OrderField;

use DateTime;
use Nuvemshop\CustomFields\Domain\Action\AbstractDeleterAction;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;

class FieldDeleterAction extends AbstractDeleterAction
{
    protected function buildEntity(AggregateInterface|CustomField $aggregate): void
    {
        $entity = $this->repository->findOneBy([
            'uuid'    => $aggregate->getUuid(),
            'storeId' => $aggregate->getStoreId()
        ]);

        $entity?->setDeletedAt(new DateTime());
    }
}
