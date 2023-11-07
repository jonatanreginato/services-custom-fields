<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use Nuvemshop\ApiTemplate\Domain\Entity\AssociationEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Enum\ValueTypeEnum;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\Association;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Repository;
use Nuvemshop\ApiTemplate\Infrastructure\Exception\PersistenceException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
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
