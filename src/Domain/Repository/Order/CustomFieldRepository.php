<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Order;

use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\DateTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\NumericTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\OptionTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\TextTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Enum\ValueTypeEnum;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class CustomFieldRepository extends AbstractRepository implements CustomFieldRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'f';
    }

    public function getByIdentifier(CustomFieldUuid $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Custom order field $identifier not found");
    }

    public function fetchOptions(CustomFieldUuid $identifier): array
    {
        $this->createBuilder(CustomFieldOptionEntity::class, 'o');

        $this->queryBuilder
            ->select('o')
            ->from(CustomFieldOptionEntity::class, 'o')
            ->innerJoin('o.customField', 'f')
            ->andWhere('f.uuid = :uuid')
            ->setParameter('uuid', (string)$identifier);

        return $this->queryBuilder->getQuery()->getResult();
    }

    public function fetchOption(CustomFieldUuid $identifier, IdentifierType $optionIdentifier): mixed
    {
        $this->createBuilder(CustomFieldOptionEntity::class, 'o');

        $this->queryBuilder
            ->select('o')
            ->from(CustomFieldOptionEntity::class, 'o')
            ->innerJoin('o.customField', 'f')
            ->andWhere('f.uuid = :uuid')
            ->andWhere('o.id = :id')
            ->setParameter('uuid', (string)$identifier)
            ->setParameter('id', (string)$optionIdentifier);

        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function fetchAssociations(CustomFieldUuid $identifier): array
    {
        $customField            = $this->getByIdentifier($identifier);
        $associationEntityClass = $this->getAssociationEntityClass($customField->getValueType());

        $this->createBuilder($associationEntityClass, 'a');

        if ($associationEntityClass === OptionTypeAssociationEntity::class) {
            $this->queryBuilder
                ->select('a')
                ->from($associationEntityClass, 'a')
                ->innerJoin('a.value', 'o')
                ->innerJoin('a.customField', 'f')
                ->andWhere('f.uuid = :uuid')
                ->setParameter('uuid', (string)$identifier);
        } else {
            $this->queryBuilder
                ->select('a')
                ->from($associationEntityClass, 'a')
                ->innerJoin('a.customField', 'f')
                ->andWhere('f.uuid = :uuid')
                ->setParameter('uuid', (string)$identifier);
        }

        return $this->queryBuilder->getQuery()->getResult();
    }

    public function fetchAssociation(CustomFieldUuid $identifier, IdentifierType $ownerIdentifier): mixed
    {
        $customField            = $this->getByIdentifier($identifier);
        $associationEntityClass = $this->getAssociationEntityClass($customField->getValueType());

        $this->createBuilder($associationEntityClass, 'a');

        if ($associationEntityClass === OptionTypeAssociationEntity::class) {
            $this->queryBuilder
                ->select('a')
                ->from($associationEntityClass, 'a')
                ->innerJoin('a.value', 'o')
                ->innerJoin('a.customField', 'f')
                ->andWhere('f.uuid = :uuid')
                ->andWhere('a.ownerId = :id')
                ->setParameter('uuid', (string)$identifier)
                ->setParameter('id', (string)$ownerIdentifier);
        } else {
            $this->queryBuilder
                ->select('a')
                ->from($associationEntityClass, 'a')
                ->innerJoin('a.customField', 'f')
                ->andWhere('f.uuid = :uuid')
                ->andWhere('a.ownerId = :id')
                ->setParameter('uuid', (string)$identifier)
                ->setParameter('id', (string)$ownerIdentifier);
        }

        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function getCountByOwner(int $storeId): array
    {
        $this->createBuilder($this->_entityName, 'a');

        $this->queryBuilder->select('COUNT(1)')
            ->from($this->_entityName, 'a')
            ->andWhere('a.storeId = :store_id')
            ->andWhere($this->queryBuilder->expr()->isNull('a.deletedAt'))
            ->setParameter('store_id', $storeId);

        return [
            'order' => $this->queryBuilder->getQuery()->getSingleScalarResult()
        ];
    }

    private function getAssociationEntityClass(int $valueType): string
    {
        return match ($valueType) {
            ValueTypeEnum::text_list->value => OptionTypeAssociationEntity::class,
            ValueTypeEnum::text->value => TextTypeAssociationEntity::class,
            ValueTypeEnum::numeric->value => NumericTypeAssociationEntity::class,
            ValueTypeEnum::date->value => DateTypeAssociationEntity::class,
        };
    }
}
