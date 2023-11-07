<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractCreatorAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Exception\DuplicatedCustomFieldException;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;

class FieldCreatorAction extends AbstractCreatorAction
{
    public function __invoke(AggregateInterface|CustomField $aggregate): EntityInterface
    {
        if (
            $this->repository->findOneBy([
                'storeId'       => $aggregate->getStoreId(),
                'key'           => $aggregate->getKey(),
                'ownerResource' => $aggregate->getOwnerResourceId(),
            ])
        ) {
            throw new DuplicatedCustomFieldException($aggregate->getKey());
        }

        return parent::__invoke($aggregate);
    }

    protected function buildEntity(AggregateInterface $aggregate): EntityInterface
    {
        $entity = new CustomFieldEntity($aggregate);
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());

        return $entity;
    }
}
