<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractDeleterAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;

class FieldDeleterAction extends AbstractDeleterAction
{
    protected function buildEntity(AggregateInterface|CustomField $aggregate): EntityInterface
    {
        $entity = $this->repository->findOneBy([
            'uuid'    => $aggregate->getUuid(),
            'storeId' => $aggregate->getStoreId()
        ]);

        $entity?->setDeletedAt(new DateTime());

        return $entity;
    }
}
