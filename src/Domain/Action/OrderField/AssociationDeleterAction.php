<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\OrderField;

use Nuvemshop\CustomFields\Domain\Entity\AssociationEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Enum\ValueTypeEnum;
use Nuvemshop\CustomFields\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\CustomFields\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\Association;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;
use Nuvemshop\CustomFields\Infrastructure\Exception\PersistenceException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class AssociationDeleterAction
{
    public function __construct(
        protected CustomFieldRepositoryInterface $orderFieldRepository,
        protected OptionTypeAssociationRepository $optionTypeOrderAssociationRepository,
        protected TextTypeAssociationRepository $textTypeOrderAssociationRepository,
        protected NumericTypeAssociationRepository $numericTypeOrderAssociationRepository,
        protected DateTypeAssociationRepository $dateTypeOrderAssociationRepository,
        protected LoggerFacade $logger,
    ) {
    }

    public function __invoke(AggregateInterface|Association $association): void
    {
        /** @var CustomFieldEntity $customFieldEntity */
        $customFieldEntity = $this->orderFieldRepository->getByIdentifier($association->customField->uuid);
        $repository        = $this->getAssociationRepository($customFieldEntity->getValueType());

        try {
            $repository->beginTransaction();

            /** @var AssociationEntityInterface|null $entity */
            $entity = $repository->findOneBy([
                'customField' => (string)$association->getCustomFieldUuid(),
                'ownerId'     => $association->getOwnerId()
            ]);

            if (!$entity) {
                throw new PersistenceException();
            }

            $repository->remove($entity);
            $repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
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
