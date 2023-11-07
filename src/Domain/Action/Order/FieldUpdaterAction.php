<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractUpdaterAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;

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
