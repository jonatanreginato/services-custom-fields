<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\OrderField;

use DateTime;
use Nuvemshop\CustomFields\Domain\Action\AbstractCreatorAction;
use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Exception\DuplicatedCustomFieldException;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;

class FieldCreatorAction extends AbstractCreatorAction
{
    public function __invoke(AggregateInterface|CustomField $aggregate, string $schemaClass): array
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

        return parent::__invoke($aggregate, $schemaClass);
    }

    protected function buildEntity(AggregateInterface $aggregate): EntityInterface
    {
        $entity = new CustomFieldEntity($aggregate);
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());

        return $entity;
    }
}
