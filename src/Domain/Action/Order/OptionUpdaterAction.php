<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractUpdaterAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\Option;

class OptionUpdaterAction extends AbstractUpdaterAction
{
    protected function buildEntity(AggregateInterface $aggregate): EntityInterface
    {
        /** @var Option $aggregate */

        $entity = $this->repository->getByIdentifier($aggregate->identifier);
        $entity
            ->setValue((string)($aggregate->optionValue ?? $entity->getValue()))
            ->setUpdatedAt(new DateTime());

        return $entity;
    }
}
