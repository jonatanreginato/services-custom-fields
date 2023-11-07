<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Entity\AssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\Association;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\Exception\PersistenceException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class AssociationUpdaterAction
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

    public function __invoke(AggregateInterface $aggregate): EntityInterface
    {
        /** @var Association $aggregate */
        /** @var CustomFieldEntity $orderFieldEntity */
        $orderFieldEntity = $this->orderFieldRepository->getByIdentifier($aggregate->customField->uuid);

        $entity = $this->getAssociationEntity($aggregate->identifier, $orderFieldEntity->getValueType());
        $entity->setValue((string)($aggregate->associationValue ?? $entity->getValue()));
        $entity->setUpdatedAt(new DateTime());

        try {
            $this->transaction($orderFieldEntity->getValueType());
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->rollback($orderFieldEntity->getValueType());
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    private function getAssociationEntity(IdentifierType $identifier, int $valueType): AssociationEntity
    {
        return match ($valueType) {
            1 => $this->optionTypeOrderAssociationRepository->getByIdentifier($identifier),
            2 => $this->textTypeOrderAssociationRepository->getByIdentifier($identifier),
            3 => $this->numericTypeOrderAssociationRepository->getByIdentifier($identifier),
            4 => $this->dateTypeOrderAssociationRepository->getByIdentifier($identifier),
        };
    }

    private function transaction(int $valueType): void
    {
        switch ($valueType) {
            case 1:
                $this->optionTypeOrderAssociationRepository->beginTransaction();
                $this->optionTypeOrderAssociationRepository->update();
                $this->optionTypeOrderAssociationRepository->commit();
                break;
            case 2:
                $this->textTypeOrderAssociationRepository->beginTransaction();
                $this->textTypeOrderAssociationRepository->update();
                $this->textTypeOrderAssociationRepository->commit();
                break;
            case 3:
                $this->numericTypeOrderAssociationRepository->beginTransaction();
                $this->numericTypeOrderAssociationRepository->update();
                $this->numericTypeOrderAssociationRepository->commit();
                break;
            case 4:
                $this->dateTypeOrderAssociationRepository->beginTransaction();
                $this->dateTypeOrderAssociationRepository->update();
                $this->dateTypeOrderAssociationRepository->commit();
                break;
        }
    }

    private function rollback(int $valueType): void
    {
        switch ($valueType) {
            case 1:
                $this->optionTypeOrderAssociationRepository->rollback();
                break;
            case 2:
                $this->textTypeOrderAssociationRepository->rollback();
                break;
            case 3:
                $this->numericTypeOrderAssociationRepository->rollback();
                break;
            case 4:
                $this->dateTypeOrderAssociationRepository->rollback();
                break;
        }
    }
}
