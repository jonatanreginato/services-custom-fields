<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\Order;

use DateTime;
use Nuvemshop\CustomFields\Domain\Action\AbstractUpdaterAction;
use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\Option;

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
