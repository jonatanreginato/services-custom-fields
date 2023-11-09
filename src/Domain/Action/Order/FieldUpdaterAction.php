<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\Order;

use DateTime;
use Nuvemshop\CustomFields\Domain\Action\AbstractUpdaterAction;
use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;

class FieldUpdaterAction extends AbstractUpdaterAction
{
    protected function buildEntity(AggregateInterface $aggregate): EntityInterface
    {
        $entity = $this->repository->getByIdentifier($aggregate->uuid);
        $entity
            ->setName((string)($aggregate->fieldName ?? $entity->getName()))
            ->setDescription((string)($aggregate->fieldDescription ?? $entity->getDescription()))
            ->setUpdatedAt(new DateTime());

        return $entity;
    }
}
