<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\Order;

use DateTime;
use Nuvemshop\CustomFields\Domain\Entity\AssociationEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\DateTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\NumericTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\OptionTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\TextTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Enum\ValueTypeEnum;
use Nuvemshop\CustomFields\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\CustomFields\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\Association;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;
use Nuvemshop\CustomFields\Infrastructure\Exception\PersistenceException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

readonly class AssociationCreatorAction
{
    public function __construct(
        protected CustomFieldRepositoryInterface $customFieldRepository,
        protected OptionRepository $optionRepository,
        protected OptionTypeAssociationRepository $optionTypeOrderAssociationRepository,
        protected TextTypeAssociationRepository $textTypeOrderAssociationRepository,
        protected NumericTypeAssociationRepository $numericTypeOrderAssociationRepository,
        protected DateTypeAssociationRepository $dateTypeOrderAssociationRepository,
        protected LoggerFacade $logger
    ) {
    }

    public function __invoke(AggregateInterface|Association $association): EntityInterface
    {
        /** @var CustomFieldEntity $customFieldEntity */
        $customFieldEntity = $this->customFieldRepository->getByIdentifier($association->getCustomFieldUuid());

        $entityClass = $this->getAssociationEntityClass($customFieldEntity->getValueType());
        $optionValue = $association->getValue();
        if ($entityClass === OptionTypeAssociationEntity::class) {
            $optionValue = $this->optionRepository->findOneBy([
                'customField' => (string)$association->getCustomFieldUuid(),
                'value'       => $association->getValue(),
            ]);
        }

        $repository = $this->getAssociationRepository($customFieldEntity->getValueType());
        /** @var AssociationEntityInterface|null $entity */
        $entity = $repository->findOneBy([
            'customField' => (string)$association->getCustomFieldUuid(),
            'ownerId'     => $association->getOwnerId()
        ]);

        if ($entity) {
            $entity->setValue($optionValue);
            $entity->setUpdatedAt(new DateTime());
            $this->update($repository);

            return $entity;
        }

        /** @var AssociationEntityInterface $entity */
        $entity = new $entityClass();
        $entity->setValue($optionValue);
        $entity->setOwnerId($association->getOwnerId());
        $entity->setCustomField($customFieldEntity);
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());
        $this->create($repository, $entity);

        return $entity;
    }

    private function update(Repository $repository): void
    {
        try {
            $repository->beginTransaction();
            $repository->update();
            $repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }

    private function create(Repository $repository, EntityInterface $entity): void
    {
        try {
            $repository->beginTransaction();
            $repository->insert($entity);
            $repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
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

    private function getAssociationRepository(int $valueType): Repository
    {
        return match ($valueType) {
            ValueTypeEnum::text_list->value => $this->optionTypeOrderAssociationRepository,
            ValueTypeEnum::text->value => $this->textTypeOrderAssociationRepository,
            ValueTypeEnum::numeric->value => $this->numericTypeOrderAssociationRepository,
            ValueTypeEnum::date->value => $this->dateTypeOrderAssociationRepository,
        };
    }
}
